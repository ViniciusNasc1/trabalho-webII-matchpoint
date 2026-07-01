@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-pencil me-2" style="color:#a78bfa;"></i>Editar Resultado
        </h4>
        <a href="{{ route('results.show', $result->id) }}" class="btn btn-mp-outline">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">

            {{-- Resumo da partida --}}
            <div class="card-mp mb-4 text-center">
                <p class="bracket-round-title mb-1">{{ $result->match->round_label }}</p>
                <small class="info-text">{{ $result->match->tournament->name ?? '' }}</small>

                <div class="d-flex justify-content-center align-items-center gap-5 mt-3">
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
            </div>

            {{-- Formulário --}}
            <div class="card-mp">
                <form action="{{ route('results.update', $result->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="score_a">
                            Placar — {{ optional($result->match->participantA)->name ?? 'Participante A' }}
                        </label>
                        <input type="text" id="score_a" name="score_a"
                               value="{{ old('score_a', $result->score_a) }}"
                               placeholder="Ex: 13, 2-1, 3">
                        @error('score_a')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="score_b">
                            Placar — {{ optional($result->match->participantB)->name ?? 'Participante B' }}
                        </label>
                        <input type="text" id="score_b" name="score_b"
                               value="{{ old('score_b', $result->score_b) }}"
                               placeholder="Ex: 5, 1-2, 1">
                        @error('score_b')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="notes">Observações <span class="info-text">(opcional)</span></label>
                        <textarea id="notes" name="notes" rows="3"
                                  placeholder="Ex: Partida disputada em overtime, WO, etc.">{{ old('notes', $result->notes) }}</textarea>
                        @error('notes')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-mp-fill w-100">
                        <i class="bi bi-check-circle me-1"></i> Salvar alterações
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection