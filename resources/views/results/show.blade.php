@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-clipboard-data-fill me-2" style="color:#a78bfa;"></i>Resultado
        </h4>
        <div class="d-flex gap-2">
            @can('update', $result)
                <a href="{{ route('results.edit', $result->id) }}" class="btn btn-mp-fill">
                    <i class="bi bi-pencil me-1"></i> Editar
                </a>
            @endcan
            <a href="{{ route('matchups.show', $result->match_id) }}" class="btn btn-mp-outline">
                <i class="bi bi-arrow-left me-1"></i> Voltar à partida
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Placar --}}
        <div class="col-12">
            <div class="card-mp text-center">
                <p class="bracket-round-title mb-1">
                    {{ $result->match->round_label }}
                </p>
                <small class="info-text">
                    {{ $result->match->tournament->name ?? '' }}
                </small>

                <div class="d-flex justify-content-center align-items-center gap-5 mt-4 mb-4">
                    <div class="text-center">
                        <div class="user-badge mx-auto mb-2">
                            {{ strtoupper(substr(optional($result->match->participantA)->name ?? 'A', 0, 1)) }}
                        </div>
                        <p class="fw-bold mb-1 bracket-participant {{ $result->match->winner_id === $result->match->participant_a_id ? 'winner' : '' }}">
                            {{ optional($result->match->participantA)->name ?? 'A definir' }}
                        </p>
                        <span class="bracket-score" style="font-size:2rem;">
                            {{ $result->score_a }}
                        </span>
                    </div>

                    <span class="bracket-round-title" style="font-size:1.5rem;">VS</span>

                    <div class="text-center">
                        <div class="user-badge mx-auto mb-2">
                            {{ strtoupper(substr(optional($result->match->participantB)->name ?? 'B', 0, 1)) }}
                        </div>
                        <p class="fw-bold mb-1 bracket-participant {{ $result->match->winner_id === $result->match->participant_b_id ? 'winner' : '' }}">
                            {{ optional($result->match->participantB)->name ?? 'A definir' }}
                        </p>
                        <span class="bracket-score" style="font-size:2rem;">
                            {{ $result->score_b }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detalhes --}}
        <div class="col-md-6 mx-auto">
            <div class="card-mp">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-info-circle me-2" style="color:#a78bfa;"></i>Detalhes
                </h5>

                <p class="info-text mb-2">
                    <i class="bi bi-person me-2"></i>
                    Registrado por: {{ $result->registeredBy->name }}
                </p>

                <p class="info-text mb-2">
                    <i class="bi bi-calendar me-2"></i>
                    {{ $result->created_at->format('d/m/Y H:i') }}
                </p>

                @if ($result->updated_at->ne($result->created_at))
                    <p class="info-text mb-2">
                        <i class="bi bi-pencil me-2"></i>
                        Editado em: {{ $result->updated_at->format('d/m/Y H:i') }}
                    </p>
                @endif

                @if ($result->notes)
                    <div class="participant-row mt-3">
                        <p class="info-text mb-0">
                            <i class="bi bi-chat-left-text me-2"></i>
                            {{ $result->notes }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection