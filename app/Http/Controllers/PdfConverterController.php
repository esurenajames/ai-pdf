<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Exception;

class PdfConverterController extends Controller
{
    public function index()
    {
        sleep(1); 
        return Inertia::render('PdfConverter');
    }   

    public function convert(Request $request)
    {
        try {
            $validated = $request->validate([
                'fileToConvert' => 'required|file|max:10240',
                'outputFilename' => 'required|string|max:255',
                'conversionSettings' => 'nullable|string|in:default,high-quality,compressed'
            ]);

            $file = $request->file('fileToConvert');
            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, ['docx', 'doc', 'txt', 'rtf', 'pptx', 'ppt', 'html'])) {
                return response()->json([
                    'error' => 'Unsupported file type: ' . $extension
                ], 422);
            }

            $outputFilename = $request->input('outputFilename');
            if (empty($outputFilename)) {
                $outputFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            }

            $result = $this->convertFile($file, $outputFilename, $request->input('conversionSettings', 'default'));

            return response()->download(
                $result['path'],
                $outputFilename . '.pdf',
                ['Content-Type' => 'application/pdf']
            )->deleteFileAfterSend(true);

        } catch (Exception $e) {
            Log::error('PDF Conversion failed: ' . $e->getMessage(), [
                'file' => $request->file('fileToConvert')->getClientOriginalName(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Conversion failed: ' . $e->getMessage()
            ], 500);
        }
    }

    protected function convertFile($file, $outputFilename, $settings)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $convertedDir = storage_path('app/converted');

        if (!is_dir($convertedDir)) {
            mkdir($convertedDir, 0777, true);
        }

        $uniqueId = uniqid();
        $outputPath = $convertedDir . DIRECTORY_SEPARATOR . 
                     $this->sanitizeFilename($outputFilename) . '_' . $uniqueId . '.pdf';

        $libreofficeExe = $this->findLibreOffice();

        $tempDir = $convertedDir . DIRECTORY_SEPARATOR . 'temp_' . $uniqueId;
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        try {
            $tempInputPath = $tempDir . DIRECTORY_SEPARATOR . $file->getClientOriginalName();
            copy($file->getPathname(), $tempInputPath);

            $command = sprintf(
                '"%s" --headless --convert-to pdf --outdir "%s" "%s" 2>&1',
                $libreofficeExe,
                str_replace('/', '\\', $tempDir),
                str_replace('/', '\\', $tempInputPath)
            );

            exec($command, $output, $resultCode);

            if ($resultCode !== 0) {
                throw new Exception("LibreOffice conversion failed: " . implode("\n", $output));
            }

            $generatedPdf = glob($tempDir . DIRECTORY_SEPARATOR . '*.pdf')[0] ?? null;
            if (!$generatedPdf || !file_exists($generatedPdf)) {
                throw new Exception("PDF file not generated");
            }

            rename($generatedPdf, $outputPath);

            if ($settings === 'compressed' || $settings === 'high-quality') {
                $compressedPath = $convertedDir . DIRECTORY_SEPARATOR . $this->sanitizeFilename($outputFilename) . '_converted.pdf';
                $this->compressPDF($outputPath, $compressedPath, $settings);
                unlink($outputPath);
                $outputPath = $compressedPath;
            }

            return [
                'path' => $outputPath,
                'filename' => basename($outputPath)
            ];

        } finally {
            if (is_dir($tempDir)) {
                array_map('unlink', glob($tempDir . DIRECTORY_SEPARATOR . '*.*'));
                rmdir($tempDir);
            }
        }
    }

    protected function compressPDF($inputPath, $outputPath, $settings)
    {
        $gsPath = 'C:\\Program Files\\gs\\gs10.04.0\\bin\\gswin64c.exe';  

        $qualitySetting = $settings === 'high-quality' ? '/prepress' : '/screen';

        $command = sprintf(
            '"%s" -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=%s -dNOPAUSE -dQUIET -dBATCH -sOutputFile="%s" "%s"',
            $gsPath,
            $qualitySetting,
            $outputPath,
            $inputPath
        );

        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            throw new Exception("Ghostscript compression failed: " . implode("\n", $output));
        }
    }

    private function findLibreOffice()
    {
        $paths = [
            'C:\\Program Files\\LibreOffice\\program\\soffice.exe',
            'C:\\Program Files (x86)\\LibreOffice\\program\\soffice.exe',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        throw new Exception('LibreOffice not found. Please install LibreOffice.');
    }

    private function sanitizeFilename($filename)
    {
        return preg_replace('/[^a-zA-Z0-9\-_]/', '', $filename);
    }
}
