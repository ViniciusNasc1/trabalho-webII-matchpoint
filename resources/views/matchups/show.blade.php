@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-diagram-3-fill me-2" style="color:#a78bfa;"></i>Partida
        </h4>
        <a href="{{ route('tournaments.show', $match->tournament_id) }}" class="btn btn-mp-outline">
            <i class="bi bi-arrow-left me-1"></i> Voltar ao torneio
        </a>
    </div>

    <div class="row g-4">

        {{-- Confronto --}}
        <div class="col-12">
            <div class="card-mp text-center">
                <p class="bracket-round-title mb-1">{{ $match->round_label }}</p>
                <small class="info-text">{{ $match->tournament->name }}</small>

                <div class="d-flex justify-content-center align-items-center gap-5 mt-4 mb-4">
                    <div class="text-center">
                        <div class="user-badge mx-auto mb-2" style="width:50px; height:50px; font-size:1.2rem;">
                            {{ strtoupper(substr(optional($match->participantA)->name ?? 'A', 0, 1)) }}
                        </div>
                        <p class="fw-bold mb-0 {{ $match->winner_id === $match->participant_a_id ? 'bracket-participant winner' : 'bracket-participant' }}">
                            {{ optional($match->participantA)->name ?? 'A definir' }}
                        </p>
                        @if ($match->result)
                            <span class="bracket-score" style="font-size:2rem;">
                                {{ $match->result->score_a }}
                            </span>
                        @endif
                    </div>

                    <span class="bracket-round-title" style="font-size:1.5rem;">VS</span>

                    <div class="text-center">
                        <div class="user-badge mx-auto mb-2" style="width:50px; height:50px; font-size:1.2rem;">
                            {{ strtoupper(substr(optional($match->participantB)->name ?? 'B', 0, 1)) }}
                        </div>
                        <p class="fw-bold mb-0 {{ $match->winner_id === $match->participant_b_id ? 'bracket-participant winner' : 'bracket-participant' }}">
                            {{ optional($match->participantB)->name ?? 'A definir' }}
                        </p>
                        @if ($match->result)
                            <span class="bracket-score" style="font-size:2rem;">
                                {{ $match->result->score_b }}
                            </span>
                        @endif
                    </div>
                </div>

                <span class="status-{{ $match->status }}">
                    {{ match($match->status) {
                        'pending' => 'Pendente',
                        'ongoing' => 'Em andamento',
                        'finished' => 'Finalizado',
                        default => $match->status
                    } }}
                </span>
            </div>
        </div>

        {{-- Registrar resultado --}}
        @can('update', $match)
            @if ($match->status !== 'finished')
                <div class="col-md-6 mx-auto">
                    <div class="card-mp">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-clipboard-check me-2" style="color:#a78bfa;"></i>
                            Registrar resultado
                        </h5>

                        <form action="{{ route('results.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="match_id" value="{{ $match->id }}">
                            <input type="hidden" name="registered_by" value="{{ auth()->id() }}">

                            <div class="mb-3">
                                <label for="score_a">
                                    Placar — {{ optional($match->participantA)->name ?? 'Participante A' }}
                                </label>
                                <input type="text" id="score_a" name="score_a"
                                       value="{{ old('score_a') }}"
                                       placeholder="Ex: 13, 2-1, 3">
                                @error('score_a')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="score_b">
                                    Placar — {{ optional($match->participantB)->name ?? 'Participante B' }}
                                </label>
                                <input type="text" id="score_b" name="score_b"
                                       value="{{ old('score_b') }}"
                                       placeholder="Ex: 5, 1-2, 1">
                                @error('score_b')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="notes">Observações <span class="info-text">(opcional)</span></label>
                                <textarea id="notes" name="notes" rows="3"
                                          placeholder="Ex: Partida disputada em overtime, WO, etc.">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-mp-fill w-100">
                                <i class="bi bi-check-circle me-1"></i> Registrar resultado
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        @endcan

        {{-- Resultado registrado --}}
        @if ($match->result)
            <div class="col-md-6 mx-auto">
                <div class="card-mp">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-clipboard-data me-2" style="color:#a78bfa;"></i>
                        Resultado
                    </h5>

                    <p class="info-text mb-1">
                        <i class="bi bi-person me-2"></i>
                        Registrado por: {{ $match->result->registeredBy->name }}
                    </p>
                    <p class="info-text mb-3">
                        <i class="bi bi-calendar me-2"></i>
                        {{ $match->result->created_at->format('d/m/Y H:i') }}
                    </p>

                    @if ($match->result->notes)
                        <div class="participant-row mt-2">
                            <p class="info-text mb-0">
                                <i class="bi bi-chat-left-text me-2"></i>
                                {{ $match->result->notes }}
                            </p>
                        </div>
                    @endif

                    @can('update', $match->result)
                        <a href="{{ route('results.edit', $match->result->id) }}"
                           class="btn btn-mp-outline w-100 mt-3">
                            <i class="bi bi-pencil me-1"></i> Editar resultado
                        </a>
                    @endcan
                </div>
            </div>
        @endif

    </div>

@endsection