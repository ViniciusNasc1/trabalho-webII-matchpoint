@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-controller me-2" style="color:#a78bfa;"></i>Jogos
        </h4>
        @can('create', App\Models\Game::class)
            <a href="{{ route('games.create') }}" class="btn btn-mp-fill">
                <i class="bi bi-plus-circle me-1"></i> Cadastrar jogo
            </a>
        @endcan
    </div>

    @if ($data->isEmpty())
        <div class="card-mp text-center py-5">
            <i class="bi bi-controller" style="font-size:3rem; color:#a78bfa;"></i>
            <p class="mt-3" style="color:#c4b8e8;">Nenhum jogo cadastrado ainda.</p>
            @can('create', App\Models\Game::class)
                <a href="{{ route('games.create') }}" class="btn btn-mp-fill mt-2">
                    Cadastrar primeiro jogo
                </a>
            @endcan
        </div>
    @else
        <div class="row g-4">
            @foreach ($data as $game)
                <div class="col-md-4">
                    <div class="card-mp h-100 d-flex flex-column justify-content-between">
                        <div>
                            @if ($game->image_url)
                                <img src="{{ $game->image_url }}" alt="{{ $game->name }}"
                                     class="img-fluid rounded mb-3"
                                     style="max-height:120px; object-fit:cover; width:100%;">
                            @else
                                <div class="d-flex align-items-center justify-content-center rounded mb-3"
                                     style="height:120px; background:rgba(124,58,237,0.15);">
                                    <i class="bi bi-controller" style="font-size:3rem; color:#a78bfa;"></i>
                                </div>
                            @endif
                            <h3>{{ $game->name }}</h3>
                            <p>
                                <i class="bi bi-display me-1" style="color:#a78bfa;"></i>
                                {{ $game->platform }}
                            </p>
                            <small style="color:#b8aede;">
                                {{ $game->tournaments->count() }} torneio(s)
                            </small>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('games.show', $game->id) }}" class="btn btn-mp-outline w-100">
                                <i class="bi bi-eye me-1"></i> Ver
                            </a>
                            @can('update', $game)
                                <a href="{{ route('games.edit', $game->id) }}" class="btn btn-mp-fill w-100">
                                    <i class="bi bi-pencil me-1"></i> Editar
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection