<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'MatchPoint' }}</title>
    @vite(['resources/js/app.js'])
</head>
<body class="app-mp">

    <nav class="navbar navbar-expand-lg navbar-mp">
        <div class="container">
            <a class="navbar-brand brand-mp" href="{{ route('dashboard') }}">Match<span>Point</span></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="bi bi-grid-fill me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tournaments.index') }}">
                            <i class="bi bi-trophy-fill me-1"></i> Torneios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('teams.index') }}">
                            <i class="bi bi-people-fill me-1"></i> Times
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('games.index') }}">
                            <i class="bi bi-controller me-1"></i> Jogos
                        </a>
                    </li>

                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="#">
                                <i class="bi bi-shield-lock-fill me-1"></i> Painel Admin
                            </a>
                        </li>
                    @endif
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                            <span class="user-badge me-2">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            {{ auth()->user()->name }}
                            @if (auth()->user()->isAdmin())
                                <span class="badge-admin ms-2">ADMIN</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-mp">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-circle me-2"></i> Perfil
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i> Sair
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if (session('success'))
            <div class="alert alert-mp-success">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-mp-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>