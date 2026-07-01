@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-trophy-fill me-2" style="color:#a78bfa;"></i>{{ $tournament->name }}
        </h4>
        <div class="d-flex gap-2">
            @can('update', $tournament)
                @if ($tournament->status === 'open')
                    <form action="{{ route('tournaments.start', $tournament->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-mp-fill"
                                onclick="return confirm('Iniciar o torneio? O bracket será gerado automaticamente.')">
                            <i class="bi bi-play-fill me-1"></i> Iniciar torneio
                        </button>
                    </form>
                @endif
                <a href="{{ route('tournaments.edit', $tournament->id) }}" class="btn btn-mp-outline">
                    <i class="bi bi-pencil me-1"></i> Editar
                </a>
            @endcan
            <a href="{{ route('tournaments.index') }}" class="btn btn-mp-outline">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Info do torneio --}}
        <div class="col-md-4">
            <div class="card-mp">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-info-circle me-2" style="color:#a78bfa;"></i>Informações
                </h5>

                <div class="d-flex flex-column gap-2">
                    <p class="info-text mb-1">
                        <i class="bi bi-controller me-2"></i>
                        {{ $tournament->game->name }}
                    </p>
                    <p class="info-text mb-1">
                        <i class="bi bi-people me-2"></i>
                        {{ $tournament->mode === 'solo' ? '1v1 (Solo)' : 'Times' }}
                    </p>
                    <p class="info-text mb-1">
                        <i class="bi bi-person-check me-2"></i>
                        {{ $tournament->participants->count() }} / {{ $tournament->max_participants }} participantes
                    </p>
                    @if ($tournament->starts_at)
                        <p class="info-text mb-1">
                            <i class="bi bi-calendar me-2"></i>
                            {{ $tournament->starts_at->format('d/m/Y') }}
                        </p>
                    @endif
                    <p class="info-text mb-1">
                        <i class="bi bi-person me-2"></i>
                        Criado por {{ $tournament->creator->name }}
                    </p>
                    <p class="mb-0">
                        <span class="status-{{ $tournament->status }}">
                            {{ match($tournament->status) {
                                'draft' => 'Rascunho',
                                'open' => 'Aberto',
                                'ongoing' => 'Em andamento',
                                'finished' => 'Finalizado',
                                default => $tournament->status
                            } }}
                        </span>
                    </p>
                </div>

                @if ($tournament->status === 'open')
                    <div class="mt-4">
                        @if ($tournament->mode === 'solo')
                            <a href="{{ route('tournament-participants.create') }}?tournament_id={{ $tournament->id }}"
                               class="btn btn-mp-fill w-100">
                                <i class="bi bi-person-plus me-1"></i> Inscrever-se
                            </a>
                        @else
                            <a href="{{ route('tournament-participants.create') }}?tournament_id={{ $tournament->id }}"
                               class="btn btn-mp-fill w-100">
                                <i class="bi bi-people me-1"></i> Inscrever time
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- Participantes --}}
        <div class="col-md-8">
            <div class="card-mp mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-people me-2" style="color:#a78bfa;"></i>Participantes
                </h5>

                @if ($tournament->participants->isEmpty())
                    <p class="info-text">Nenhum participante inscrito ainda.</p>
                @else
                    <div class="d-flex flex-column gap-2">
                        @foreach ($tournament->participants as $participant)
                            <div class="participant-row d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="user-badge">
                                        {{ strtoupper(substr(optional($participant->participant)->name, 0, 1)) }}
                                    </span>
                                    <span class="fw-bold">
                                        {{ optional($participant->participant)->name }}
                                    </span>
                                </div>
                                @can('delete', $tournament)
                                    <form action="{{ route('tournament-participants.destroy', $participant->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-mp btn-sm"
                                                onclick="return confirm('Remover este participante?')">
                                            <i class="bi bi-person-x"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Bracket --}}
            @if ($tournament->matches->isNotEmpty())
                <div class="card-mp">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-diagram-3 me-2" style="color:#a78bfa;"></i>Bracket
                    </h5>

                    @php
                        $rounds = $tournament->matches->groupBy('round_number')->sortKeys();
                    @endphp

                    <div class="d-flex gap-4 overflow-auto pb-2">
                        @foreach ($rounds as $roundNumber => $matches)
                            <div class="bracket-column">
                                <p class="bracket-round-title mb-3 text-center">
                                    {{ $matches->first()->round_label }}
                                </p>
                                <div class="d-flex flex-column gap-3">
                                    @foreach ($matches as $match)
                                        <div class="bracket-match">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="bracket-participant {{ $match->winner_id === $match->participant_a_id ? 'winner' : '' }}">
                                                    {{ optional($match->participantA)->name ?? 'A definir' }}
                                                </span>
                                                @if ($match->result)
                                                    <span class="bracket-score">
                                                        {{ $match->result->score_a }}
                                                    </span>
                                                @endif
                                            </div>

                                            <hr class="bracket-divider">

                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <span class="bracket-participant {{ $match->winner_id === $match->participant_b_id ? 'winner' : '' }}">
                                                    {{ optional($match->participantB)->name ?? 'A definir' }}
                                                </span>
                                                @if ($match->result)
                                                    <span class="bracket-score">
                                                        {{ $match->result->score_b }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <span class="status-{{ $match->status }}">
                                                    {{ match($match->status) {
                                                        'pending' => 'Pendente',
                                                        'ongoing' => 'Em andamento',
                                                        'finished' => 'Finalizado',
                                                        default => $match->status
                                                    } }}
                                                </span>
                                                @can('update', $match)
                                                    @if ($match->status !== 'finished')
                                                        <a href="{{ route('matchups.show', $match->id) }}"
                                                           class="btn btn-mp-outline btn-sm">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    @endif
                                                @endcan
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection