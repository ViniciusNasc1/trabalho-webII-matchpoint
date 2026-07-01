@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-diagram-3-fill me-2" style="color:#a78bfa;"></i>Partidas
        </h4>
    </div>

    @if ($data->isEmpty())
        <div class="card-mp text-center py-5">
            <i class="bi bi-diagram-3" style="font-size:3rem; color:#a78bfa;"></i>
            <p class="mt-3 info-text">Nenhuma partida cadastrada ainda.</p>
        </div>
    @else
        <div class="d-flex flex-column gap-3">
            @foreach ($data as $match)
                <div class="card-mp">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="fw-bold mb-1">
                                {{ $match->tournament->name ?? 'Torneio não encontrado' }}
                            </p>
                            <small class="info-text">
                                {{ $match->round_label }}
                            </small>
                        </div>

                        <div class="d-flex align-items-center gap-4">
                            <div class="text-center">
                                <p class="fw-bold mb-0">
                                    {{ optional($match->participantA)->name ?? 'A definir' }}
                                </p>
                                @if ($match->result)
                                    <span class="bracket-score">{{ $match->result->score_a }}</span>
                                @endif
                            </div>

                            <span class="bracket-round-title">VS</span>

                            <div class="text-center">
                                <p class="fw-bold mb-0">
                                    {{ optional($match->participantB)->name ?? 'A definir' }}
                                </p>
                                @if ($match->result)
                                    <span class="bracket-score">{{ $match->result->score_b }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <span class="status-{{ $match->status }}">
                                {{ match($match->status) {
                                    'pending' => 'Pendente',
                                    'ongoing' => 'Em andamento',
                                    'finished' => 'Finalizado',
                                    default => $match->status
                                } }}
                            </span>
                            <a href="{{ route('matchups.show', $match->id) }}"
                               class="btn btn-mp-outline btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection