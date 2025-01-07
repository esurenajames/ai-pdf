<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Barryvdh\DomPDF\Facade\Pdf; 
use Inertia\Inertia;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Paragraph;
use PhpOffice\PhpWord\Element\Table;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function index()
    {
        sleep(1); 
        return Inertia::render('quiz');
    }

    public function generateQuiz(Request $request)
    {
        // Validate the request data
        $request->validate([
            'file' => 'required|file|mimes:pdf,docx,txt,pptx',
            'questionTypes' => 'required|array',
        ]);
    
        $file = $request->file('file');
        $questionTypes = $request->input('questionTypes');
    
        // Log the received question types and their counts
        Log::info('Received question types:', $questionTypes);
    
        // Extract text from the file
        $text = $this->extractTextFromFile($file);
    
        // Generate the prompt based on the text and question types
        $prompt = $this->generatePrompt($text, $questionTypes);
    
        // Log the generated prompt for debugging
        Log::info('Generated prompt:', ['prompt' => $prompt]);
    
        // Interact with OpenAI to generate quiz questions using chat completion
        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo', // Use gpt-3.5-turbo instead of gpt-4
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant that generates quiz questions.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 1500,
        ]);        
    
        // Log the OpenAI response
        Log::info('OpenAI response:', ['response' => $response]);
    
        // Parse the response to extract quiz questions
        $questions = $this->parseOpenAIResponse($response);
    
        // Log the parsed questions
        Log::info('Parsed questions:', ['questions' => $questions]);
    
        // Return the Inertia response with the questions as part of the props
        return Inertia::render('Quiz', [
            'questions' => $questions
        ]);
    }    

    private function extractTextFromFile($file)
    {
        $extension = $file->getClientOriginalExtension();
        
        switch ($extension) {
            case 'pdf':
                // Extract text from PDF
                $parser = new Parser();
                $pdf = $parser->parseFile($file->getPathname());
                return $pdf->getText();

            case 'docx':
                // Extract text from DOCX
                $phpWord = IOFactory::load($file->getPathname());
                $text = '';
                
                // Extract text from each section
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        $text .= $this->extractTextFromWordElement($element) . "\n"; // Call a recursive function
                    }
                }
                
                return $text;

            case 'txt':
                // Extract text from TXT
                return file_get_contents($file->getPathname());

            case 'pptx':
                // Placeholder for PPTX extraction
                return 'Text extraction for pptx is not yet implemented';

            default:
                throw new \Exception("Unsupported file type");
        }
    }

    /**
     * Recursively extract text from PhpWord elements
     * 
     * @param object $element
     * @return string
     */
    private function extractTextFromWordElement($element)
    {
        $text = '';
        
        // Extract text for Paragraphs (main content holders in Word files)
        if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
            $text .= $element->getText();
        }
        elseif ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
            foreach ($element->getElements() as $childElement) {
                $text .= $this->extractTextFromWordElement($childElement); // Recursive call for nested text
            }
        }
        elseif ($element instanceof \PhpOffice\PhpWord\Element\Paragraph) {
            foreach ($element->getElements() as $childElement) {
                $text .= $this->extractTextFromWordElement($childElement); // Recursive call for nested text
            }
        }
        elseif ($element instanceof \PhpOffice\PhpWord\Element\Table) {
            foreach ($element->getRows() as $row) {
                foreach ($row->getCells() as $cell) {
                    foreach ($cell->getElements() as $cellElement) {
                        $text .= $this->extractTextFromWordElement($cellElement); // Extract text from each cell
                    }
                }
            }
        }

        // Optionally, add a newline for better readability
        return $text . "\n";
    }

    public function generatePdf(Request $request)
    {
        // Get the data from the request (ensure it matches the structure)
        $questions = $request->input('questions', []);

        // Generate the PDF from the blade view
        $pdf = PDF::loadView('pdf.quiz-prompt', ['questions' => $questions]);

        // Return the PDF as a download
        return $pdf->download('quiz-prompt.pdf');
    }


    private function generatePrompt($text, $questionTypes)
    {
        $prompt = "Create a quiz based on the following content:\n\n$text\n\n";
        
        $prompt .= "Please generate the quiz with the following guidelines:\n";
        $prompt .= "- For each question, provide a clear question text.\n";
        $prompt .= "- For multiple-choice questions, always provide exactly 4 options labeled A, B, C, and D.\n";
        $prompt .= "- **Ensure that only one of the options has '(Correct)' at the end of the answer.**\n";
        $prompt .= "- **Make sure no other options are marked as correct**.\n";
        $prompt .= "- **Do not mark more than one option with '(Correct)'**.\n";
        $prompt .= "- The correct answer should be a factually correct answer based on the provided content.\n";
        $prompt .= "- For True or False questions, provide only two options: True and False.\n";
        $prompt .= "- Format the output exactly as follows:\n";
        $prompt .= "  Question X: [Full question text]\n";
        $prompt .= "  A) [Option 1] (Correct if this is the right answer)\n";
        $prompt .= "  B) [Option 2]\n";
        $prompt .= "  C) [Option 3]\n";
        $prompt .= "  D) [Option 4]\n";
        
        // Add the requested question types and counts to the prompt
        foreach ($questionTypes as $type) {
            $prompt .= "Generate {$type['count']} questions of type '{$type['label']}'.\n";
        }
        
        return $prompt;
    }    
    
    private function parseOpenAIResponse($response)
    {
        $questionsText = $response['choices'][0]['message']['content'];
        $questions = [];
        $lines = explode("\n", $questionsText);
        $currentQuestion = null;
        $currentOptions = [];
        $correctAnswer = null;
        $questionCounter = 0; // This will be used to number questions like 1.), 2.), 3.), etc.

        foreach ($lines as $line) {
            $line = trim($line);
            
            // Check if line is a question (starts with 'Question' or contains a question mark)
            if (preg_match('/^Question \d+:(.*)/', $line, $matches)) {
                // If we had a previous question, add it to the questions array
                if ($currentQuestion !== null) {
                    $questions[] = [
                        'text' => $currentQuestion,
                        'type' => 'multiple_choice',
                        'options' => array_map(function($option) {
                            return preg_replace('/\s*\(Correct\)/', '', $option); // Remove (Correct) from options
                        }, $currentOptions),
                        'answer' => $correctAnswer ? preg_replace('/\s*\(Correct\)/', '', $correctAnswer) : 'N/A'
                    ];

                    // Reset for the next question
                    $currentOptions = [];
                    $correctAnswer = null;
                }

                // Increment the question counter
                $questionCounter++;

                // Remove "Question X:" from the question text and add "1.)", "2.)", etc.
                $currentQuestion = $questionCounter . '.) ' . trim($matches[1]); // Extracts text after "Question X:"
            } 
            // Check if line looks like an option (A) B) C) D))
            elseif (preg_match('/^[A-D]\)/', $line)) {
                $cleanedOption = preg_replace('/\s*\(Correct\)/', '', $line); // Remove (Correct) from the option
                $currentOptions[] = $cleanedOption;

                // If the current option is marked as (Correct), store it as the correct answer
                if (preg_match('/\(Correct\)/', $line)) {
                    $correctAnswer = $cleanedOption;
                }
            } 
            // Check if True/False question format
            elseif (preg_match('/^(True|False)$/i', $line)) {
                $cleanedOption = preg_replace('/\s*\(Correct\)/', '', $line); // Remove (Correct) from the option
                $currentOptions[] = $cleanedOption;

                // Check if the correct answer is mentioned in this line
                if (preg_match('/\(Correct\)/i', $line)) {
                    $correctAnswer = $cleanedOption;
                }
            }
        }

        // Add the last question to the questions array
        if ($currentQuestion !== null) {
            $questions[] = [
                'text' => $currentQuestion,
                'type' => 'multiple_choice',
                'options' => array_map(function($option) {
                    return preg_replace('/\s*\(Correct\)/', '', $option); // Remove (Correct) from options
                }, $currentOptions),
                'answer' => $correctAnswer ? preg_replace('/\s*\(Correct\)/', '', $correctAnswer) : 'N/A'
            ];
        }

        return $questions;
    }
}