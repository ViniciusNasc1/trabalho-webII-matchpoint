@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-plus-circle me-2" style="color:#a78bfa;"></i>Criar Torneio
        </h4>
        <a href="{{ route('tournaments.index') }}" class="btn btn-mp-outline">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-mp">
                <form action="{{ route('tournaments.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name">Nome do torneio</label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name') }}"
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
                                    {{ old('game_id') == $game->id ? 'selected' : '' }}>
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
                            <option value="">Selecione o modo</option>
                            <option value="solo" {{ old('mode') === 'solo' ? 'selected' : '' }}>
                                1v1 (Solo)
                            </option>
                            <option value="team" {{ old('mode') === 'team' ? 'selected' : '' }}>
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
                               value="{{ old('max_participants') }}"
                               placeholder="Ex: 8, 16, 32"
                               min="2">
                        @error('max_participants')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="starts_at">Data de início <span style="color:#b8aede;">(opcional)</span></label>
                        <input type="date" id="starts_at" name="starts_at"
                               value="{{ old('starts_at') }}">
                        @error('starts_at')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-mp-fill w-100">
                        <i class="bi bi-check-circle me-1"></i> Criar torneio
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection