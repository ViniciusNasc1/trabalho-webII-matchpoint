@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold">Olá, {{ auth()->user()->name }}</h2>
        <p style="color:#c4b8e8;">Bem-vindo de volta ao MatchPoint.</p>
    </div>

    <div class="row g-4">
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
                <h3>Meus times</h3>
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

        @if (auth()->user()->isAdmin())
            <div class="col-12">
                <div class="card-mp border-warning">
                    <i class="bi bi-shield-lock-fill text-warning"></i>
                    <h3>Painel administrativo</h3>
                    <p>Como admin, você pode criar torneios, cadastrar jogos e registrar resultados de partidas.</p>
                    <a href="{{