<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Prompt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        span{
            font-weight: bold;
        }
        .quiz-container, .answer-key {
            max-width: 800px;
            margin: 0 auto;
        }
        h1, h2, h3 {
            color: #333;
        }
        .question {
            margin-bottom: 10px;
            padding-bottom: 20px;
        }
        .options {
            list-style-type: none;
            padding-left: 0;
        }
        .options li {
            margin-bottom: 10px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <div class="quiz-container">
        @if (!empty($questions) && is_array($questions))
            @foreach ($questions as $index => $question)
                <div class="question">
                    <p>{{ $question['text'] }}</p>

                    @if (!empty($question['options']) && is_array($question['options']))
                        <ul class="options">
                            @foreach ($question['options'] as $option)
                                <li>{{ $option }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        @else
            <p>No questions available.</p>
        @endif
    </div>

    <div class="page-break"></div>

    <div class="answer-key">
        <h2>Answer Key</h2>
        @foreach ($questions as $index => $question)
            <p> {{ $index + 1 }}.) {{ $question['answer'] ?? 'N/A' }}</p>
        @endforeach
    </div>

</body>
</html>