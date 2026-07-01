@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-person-plus me-2" style="color:#a78bfa;"></i>Inscrever no Torneio
        </h4>
        <a href="{{ route('tournaments.show', request('tournament_id')) }}" class="btn btn-mp-outline">
            <i class="bi bi-arrow-left me-1"></i> Voltar ao torneio
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-mp">
                <form action="{{ route('tournament-participants.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="tournament_id" value="{{ request('tournament_id') }}">

                    @if ($tournament->mode === 'solo')
                        <input type="hidden" name="participant_type" value="App\Models\User">
                        <input type="hidden" name="participant_id" value="{{ auth()->id() }}">

                        <div class="card-mp mb-4 text-center">
                            <i class="bi bi-person-circle" style="font-size:2.5rem; color:#a78bfa;"></i>
                            <p class="fw-bold mt-2 mb-0">{{ auth()->user()->name }}</p>
                            <small class="info-text">Você será inscrito como jogador solo</small>
                        </div>
                    @else
                        <input type="hidden" name="participant_type" value="App\Models\Team">

                        <div class="mb-4">
                            <label for="participant_id">Selecione seu time</label>
                            <select id="participant_id" name="participant_id">
                                <option value="">Selecione um time</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}"
                                        {{ old('participant_id') == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }} — {{ $team->tag }}
                                    </option>
                                @endforeach
                            </select>
                            @error('participant_id')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <button type="submit" class="btn btn-mp-fill w-100">
                        <i class="bi bi-check-circle me-1"></i> Confirmar inscrição
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection