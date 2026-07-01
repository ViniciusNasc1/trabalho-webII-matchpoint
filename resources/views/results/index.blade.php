@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-clipboard-data-fill me-2" style="color:#a78bfa;"></i>Resultados
        </h4>
    </div>

    @if ($data->isEmpty())
        <div class="card-mp text-center py-5">
            <i class="bi bi-clipboard-data" style="font-size:3rem; color:#a78bfa;"></i>
            <p class="mt-3 info-text">Nenhum resultado registrado ainda.</p>
        </div>
    @else
        <div class="d-flex flex-column gap-3">
            @foreach ($data as $result)
                <div class="card-mp">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="fw-bold mb-1">
                                {{ $result->match->tournament->name ?? 'Torneio não encontrado' }}
                            </p>
                            <small class="info-text">
                                {{ $result->match->round_label ?? '' }}
                            </small>
                        </div>

                        <div class="d-flex align-items-center gap-4">
                            <div class="text-center">
                                <p class="fw-bold mb-0">
                                    {{ optional($result->match->participantA)->name ?? 'A definir' }}
                                </p>
                                <span class="bracket-score">{{ $result->score_a }}</span>
                            </div>

                            <span class="bracket-round-title">VS</span>

                            <div class="text-center">
                                <p class="fw-bold mb-0">
                                    {{ optional($result->match->participantB)->name ?? 'A definir' }}
                                </p>
                                <span class="bracket-score">{{ $result->score_b }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <small class="info-text">
                                {{ $result->created_at->format('d/m/Y H:i') }}
                            </small>
                            <a href="{{ route('results.show', $result->id) }}"
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