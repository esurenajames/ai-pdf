<!DOCTYPE html>
<html>
<head>
    <title>{{ $filename ?? 'Converted Document' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
        }
    </style>
</head>
<body>
    <h1>{{ $filename ?? 'Converted Document' }}</h1>
    <p>{{ $content }}</p>
</body>
</html>