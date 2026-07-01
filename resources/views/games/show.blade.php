@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-controller me-2" style="color:#a78bfa;"></i>{{ $game->name }}
        </h4>
        <div class="d-flex gap-2">
            @can('update', $game)
                <a href="{{ route('games.edit', $game->id) }}" class="btn btn-mp-fill">
                    <i class="bi bi-pencil me-1"></i> Editar
                </a>
            @endcan
            <a href="{{ route('games.index') }}" class="btn btn-mp-outline">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card-mp text-center">
                @if ($game->image_url)
                    <img src="{{ $game->image_url }}" alt="{{ $game->name }}"
                         class="img-fluid rounded mb-3"
                         style="max-height:200px; object-fit:cover; width:100%;">
                @else
                    <div class="d-flex align-items-center justify-content-center rounded mb-3"
                         style="height:200px; background:rgba(124,58,237,0.15);">
                        <i class="bi bi-controller" style="font-size:4rem; color:#a78bfa;"></i>
                    </div>
                @endif
                <h3>{{ $game->name }}</h3>
                <p class="mt-2">
                    <i class="bi bi-display me-1" style="color:#a78bfa;"></i>
                    {{ $game->platform }}
                </p>
                <small style="color:#b8aede;">
                    Cadastrado em {{ $game->created_at->format('d/m/Y') }}
                </small>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card-mp">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-trophy me-2" style="color:#a78bfa;"></i>
                    Torneios com este jogo
                </h5>

                @if ($game->tournaments->isEmpty())
                    <p style="color:#b8aede;">Nenhum torneio cadastrado para este jogo ainda.</p>
                @else
                    <div class="d-flex flex-column gap-2">
                        @foreach ($game->tournaments as $tournament)
                            <div class="d-flex justify-content-between align-items-center p-3 rounded"
                                 style="background:rgba(124,58,237,0.08); border:1px solid rgba(124,58,237,0.2);">
                                <div>
                                    <span class="fw-bold">{{ $tournament->name }}</span>
                                    <small class="d-block" style="color:#b8aede;">
                                        {{ $tournament->mode === 'solo' ? '1v1' : 'Times' }} •
                                        {{ $tournament->max_participants }} participantes
                                    </small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="px-2 py-1 rounded"
                                          style="font-size:0.75rem; background:rgba(124,58,237,0.2); color:#a78bfa;">
                                        {{ ucfirst($tournament->status) }}
                                    </span>
                                    <a href="{{ route('tournaments.show', $tournament->id) }}"
                                       class="btn btn-mp-outline btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection