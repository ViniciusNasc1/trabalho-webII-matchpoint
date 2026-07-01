@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-person-check me-2" style="color:#a78bfa;"></i>Inscrição
        </h4>
        <a href="{{ route('tournaments.show', $participant->tournament_id) }}" class="btn btn-mp-outline">
            <i class="bi bi-arrow-left me-1"></i> Voltar ao torneio
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-mp">

                <h5 class="fw-bold mb-3">
                    <i class="bi bi-info-circle me-2" style="color:#a78bfa;"></i>Detalhes da inscrição
                </h5>

                <div class="d-flex flex-column gap-2">
                    <p class="info-text mb-1">
                        <i class="bi bi-trophy me-2"></i>
                        Torneio: {{ $participant->tournament->name }}
                    </p>

                    <p class="info-text mb-1">
                        <i class="bi bi-person me-2"></i>
                        Participante: {{ optional($participant->participant)->name }}
                    </p>

                    <p class="info-text mb-1">
                        <i class="bi bi-people me-2"></i>
                        Tipo: {{ $participant->participant_type === 'App\Models\User' ? 'Jogador solo' : 'Time' }}
                    </p>

                    <p class="info-text mb-0">
                        <i class="bi bi-calendar me-2"></i>
                        Inscrito em: {{ $participant->registered_at?->format('d/m/Y H:i') ?? $participant->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                @can('delete', $participant->tournament)
                    <form action="{{ route('tournament-participants.destroy', $participant->id) }}"
                          method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-mp w-100"
                                onclick="return confirm('Remover este participante do torneio?')">
                            <i class="bi bi-person-x me-1"></i> Remover inscrição
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>

@endsection