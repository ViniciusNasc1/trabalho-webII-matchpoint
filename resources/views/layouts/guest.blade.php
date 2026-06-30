<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MatchPoint</title>
    @vite(['resources/js/app.js'])
</head>
<body class="auth-mp">
    <div class="auth-wrapper">
        <a href="{{ route('home') }}" class="auth-brand">Match<span>Point</span></a>

        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>