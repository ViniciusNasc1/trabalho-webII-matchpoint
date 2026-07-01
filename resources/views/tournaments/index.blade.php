@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-trophy-fill me-2" style="color:#a78bfa;"></i>Torneios
        </h4>
        @can('create', App\Models\Tournament::class)
            <a href="{{ route('tournaments.create') }}" class="btn btn-mp-fill">
                <i class="bi bi-plus-circle me-1"></i> Criar torneio
            </a>
        @endcan
    </div>

    @if ($data->isEmpty())
        <div class="card-mp text-center py-5">
            <i class="bi bi-trophy" style="font-size:3rem; color:#a78bfa;"></i>
            <p class="mt-3" style="color:#c4b8e8;">Nenhum torneio cadastrado ainda.</p>
            @can('create', App\Models\Tournament::class)
                <a href="{{ route('tournaments.create') }}" class="btn btn-mp-fill mt-2">
                    Criar primeiro torneio
                </a>
            @endcan
        </div>
    @else
        <div class="row g-4">
            @foreach ($data as $tournament)
                <div class="col-md-4">
                    <div class="card-mp h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="status-{{ $tournament->mode === 'solo' ? 'solo' : 'team' }}">
                                    {{ $tournament->mode === 'solo' ? '1v1' : 'Times' }}
                                </span>
                                <span class="status-{{ $tournament->status }}">
                                    {{ match($tournament->status) {
                                        'draft' => 'Rascunho',
                                        'open' => 'Aberto',
                                        'ongoing' => 'Em andamento',
                                        'finished' => 'Finalizado',
                                        default => $tournament->status
                                    } }}
                                </span>
                            </div>

                            <h3>{{ $tournament->name }}</h3>

                            <p style="color:#b8aede; font-size:0.9rem;">
                                <i class="bi bi-controller me-1"></i>
                                {{ $tournament->game->name }}
                            </p>

                            <p style="color:#b8aede; font-size:0.9rem;">
                                <i class="bi bi-people me-1"></i>
                                {{ $tournament->participants->count() }} / {{ $tournament->max_participants }} participantes
                            </p>

                            @if ($tournament->starts_at)
                                <p style="color:#b8aede; font-size:0.9rem;">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $tournament->starts_at->format('d/m/Y') }}
                                </p>
                            @endif
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('tournaments.show', $tournament->id) }}"
                               class="btn btn-mp-outline w-100">
                                <i class="bi bi-eye me-1"></i> Ver
                            </a>
                            @can('update', $tournament)
                                <a href="{{ route('tournaments.edit', $tournament->id) }}"
                                   class="btn btn-mp-fill w-100">
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