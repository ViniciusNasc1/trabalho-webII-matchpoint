@extends('layouts.app')

@section('content')

    {{-- Cabeçalho --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Olá, {{ auth()->user()->name }}</h4>
            <small style="color:#c4b8e8;">
                {{ now()->format('l, d \d\e F \d\e Y') }}
            </small>
        </div>
        @if (auth()->user()->isAdmin())
            <span class="badge-admin px-3 py-2" style="font-size:0.8rem;">
                <i class="bi bi-shield-lock-fill me-1"></i> Administrador
            </span>
        @endif
    </div>

    {{-- Cards de acesso rápido --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card-mp">
                <i class="bi bi-trophy-fill"></i>
                <h3>Torneios</h3>
                <p>Veja os torneios disponíveis e acompanhe os que você já está inscrito.</p>
                <a href="{{ route('tournaments.index') }}" class="btn btn-mp-outline mt-2">
                    Ver torneios
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-mp">
                <i class="bi bi-people-fill"></i>
                <h3>Times</h3>
                <p>Gerencie seus times ou crie um novo para competir.</p>
                <a href="{{ route('teams.index') }}" class="btn btn-mp-outline mt-2">
                    Ver times
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-mp">
                <i class="bi bi-controller"></i>
                <h3>Jogos</h3>
                <p>Confira todos os jogos disponíveis na plataforma.</p>
                <a href="{{ route('games.index') }}" class="btn btn-mp-outline mt-2">
                    Ver jogos
                </a>
            </div>
        </div>
    </div>

    {{-- Seção exclusiva do admin --}}
    @if (auth()->user()->isAdmin())
        <div class="mb-3">
            <h5 class="fw-bold" style="color:#a78bfa;">
                <i class="bi bi-shield-lock-fill me-2"></i>Painel Administrativo
            </h5>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card-mp text-center">
                    <i class="bi bi-trophy" style="font-size:2rem; color:#a78bfa;"></i>
                    <h3 class="mt-2">Torneios</h3>
                    <a href="{{ route('tournaments.create') }}" class="btn btn-mp-fill mt-2 w-100">
                        <i class="bi bi-plus-circle me-1"></i> Criar torneio
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-mp text-center">
                    <i class="bi bi-controller" style="font-size:2rem; color:#a78bfa;"></i>
                    <h3 class="mt-2">Jogos</h3>
                    <a href="{{ route('games.create') }}" class="btn btn-mp-fill mt-2 w-100">
                        <i class="bi bi-plus-circle me-1"></i> Cadastrar jogo
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-mp text-center">
                    <i class="bi bi-diagram-3" style="font-size:2rem; color:#a78bfa;"></i>
                    <h3 class="mt-2">Partidas</h3>
                    <a href="{{ route('matchups.index') }}" class="btn btn-mp-fill mt-2 w-100">
                        <i class="bi bi-eye me-1"></i> Ver partidas
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-mp text-center">
                    <i class="bi bi-clipboard-data" style="font-size:2rem; color:#a78bfa;"></i>
                    <h3 class="mt-2">Resultados</h3>
                    <a href="{{ route('results.index') }}" class="btn btn-mp-fill mt-2 w-100">
                        <i class="bi bi-eye me-1"></i> Ver resultados
                    </a>
                </div>
            </div>
        </div>
    @endif

@endsection