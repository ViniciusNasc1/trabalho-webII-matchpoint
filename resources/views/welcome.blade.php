<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MatchPoint - Torneios de Games</title>
    @vite(['resources/js/app.js'])
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-mp">
        <div class="container py-2">
            <a class="navbar-brand brand-mp" href="{{ route('home') }}">Match<span>Point</span></a>
            <div class="ms-auto d-flex gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-mp-fill px-4">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-mp-outline px-4">Entrar</a>
                    <a href="{{ route('register') }}" class="btn btn-mp-fill px-4">Cadastrar</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="hero-mp">
        <div class="container">
            <h1 class="hero-title">Match<span>Point</span></h1>
            <p class="hero-lead mt-3">
                A plataforma definitiva para organizar e participar de torneios de games.
                Solo ou em equipe, sua próxima vitória começa aqui.
            </p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-mp-fill btn-lg mt-4 px-5">
                    <i class="bi bi-lightning-charge-fill me-1"></i> Começar agora
                </a>
            @endguest
        </div>
    </header>

    <section class="container py-3">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="card-mp">
                    <i class="bi bi-controller"></i>
                    <h3>Múltiplos jogos</h3>
                    <p>CS2, Valorant, FIFA, Mortal Kombat e muito mais em um só lugar.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-mp">
                    <i class="bi bi-people-fill"></i>
                    <h3>Solo ou times</h3>
                    <p>Participe sozinho em torneios 1v1 ou monte seu time para competir.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-mp">
                    <i class="bi bi-diagram-3-fill"></i>
                    <h3>Brackets automáticos</h3>
                    <p>Acompanhe o chaveamento de eliminação simples em tempo real.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center py-4 footer-mp">
        <small>MatchPoint &copy; {{ date('Y') }} — Trabalho de Desenvolvimento Web II</small>
    </footer>

</body>
</html>