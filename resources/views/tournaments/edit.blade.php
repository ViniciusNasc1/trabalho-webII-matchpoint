@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-pencil me-2" style="color:#a78bfa;"></i>Editar Torneio
        </h4>
        <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn btn-mp-outline">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-mp">
                <form action="{{ route('tournaments.update', $tournament->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name">Nome do torneio</label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name', $tournament->name) }}"
                               placeholder="Ex: Copa MatchPoint #1">
                        @error('name')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="game_id">Jogo</label>
                        <select id="game_id" name="game_id">
                            <option value="">Selecione um jogo</option>
                            @foreach ($games as $game)
                                <option value="{{ $game->id }}"
                                    {{ old('game_id', $tournament->game_id) == $game->id ? 'selected' : '' }}>
                                    {{ $game->name }} — {{ $game->platform }}
                                </option>
                            @endforeach
                        </select>
                        @error('game_id')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mode">Modo</label>
                        <select id="mode" name="mode">
                            <option value="solo" {{ old('mode', $tournament->mode) === 'solo' ? 'selected' : '' }}>
                                1v1 (Solo)
                            </option>
                            <option value="team" {{ old('mode', $tournament->mode) === 'team' ? 'selected' : '' }}>
                                Times
                            </option>
                        </select>
                        @error('mode')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="max_participants">Máximo de participantes</label>
                        <input type="number" id="max_participants" name="max_participants"
                               value="{{ old('max_participants', $tournament->max_participants) }}"
                               placeholder="Ex: 8, 16, 32"
                               min="2">
                        @error('max_participants')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="draft" {{ old('status', $tournament->status) === 'draft' ? 'selected' : '' }}>
                                Rascunho
                            </option>
                            <option value="open" {{ old('status', $tournament->status) === 'open' ? 'selected' : '' }}>
                                Aberto
                            </option>
                            <option value="ongoing" {{ old('status', $tournament->status) === 'ongoing' ? 'selected' : '' }}>
                                Em andamento
                            </option>
                            <option value="finished" {{ old('status', $tournament->status) === 'finished' ? 'selected' : '' }}>
                                Finalizado
                            </option>
                        </select>
                        @error('status')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="starts_at">Data de início <span style="color:#b8aede;">(opcional)</span></label>
                        <input type="date" id="starts_at" name="starts_at"
                               value="{{ old('starts_at', $tournament->starts_at?->format('Y-m-d')) }}">
                        @error('starts_at')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-mp-fill w-100">
                        <i class="bi bi-check-circle me-1"></i> Salvar alterações
                    </button>
                </form>

                @can('delete', $tournament)
                    <form action="{{ route('tournaments.destroy', $tournament->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn w-100"
                                style="border:1px solid rgba(239,68,68,0.4); color:#fca5a5; background:rgba(239,68,68,0.08);"
                                onclick="return confirm('Tem certeza que deseja remover este torneio?')">
                            <i class="bi bi-trash me-1"></i> Remover torneio
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>

@endsection