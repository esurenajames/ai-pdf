<!DOCTYPE html>
<html lang="en">
    <style>
        @font-face {
            font-family: 'CustomFont';
            src: url('/path/to/font.ttf') format('truetype');
        }
        body {
            font-family: 'CustomFont', sans-serif;
        }
    </style>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <!-- Render content with inline images -->
    {!! $content !!}
</body>
</html>
