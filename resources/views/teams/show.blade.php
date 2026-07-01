@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-people-fill me-2" style="color:#a78bfa;"></i>{{ $team->name }}
            <span class="px-2 py-1 rounded ms-2"
                  style="font-size:0.75rem; background:rgba(124,58,237,0.2); color:#a78bfa;">
                {{ $team->tag }}
            </span>
        </h4>
        <div class="d-flex gap-2">
            @can('update', $team)
                <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-mp-fill">
                    <i class="bi bi-pencil me-1"></i> Editar
                </a>
            @endcan
            <a href="{{ route('teams.index') }}" class="btn btn-mp-outline">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Info do time --}}
        <div class="col-md-4">
            <div class="card-mp text-center">
                @if ($team->logo_url)
                    <img src="{{ $team->logo_url }}" alt="{{ $team->name }}"
                         class="img-fluid rounded mb-3"
                         style="max-height:150px; object-fit:cover; width:100%;">
                @else
                    <div class="d-flex align-items-center justify-content-center rounded mb-3"
                         style="height:150px; background:rgba(124,58,237,0.15);">
                        <i class="bi bi-people" style="font-size:3.5rem; color:#a78bfa;"></i>
                    </div>
                @endif

                <h3>{{ $team->name }}</h3>
                <p style="color:#a78bfa;">{{ $team->tag }}</p>

                <div class="mt-2" style="color:#b8aede; font-size:0.9rem;">
                    <p class="mb-1">
                        <i class="bi bi-person-circle me-1"></i>
                        Dono: {{ $team->owner->name }}
                    </p>
                    <p class="mb-1">
                        <i class="bi bi-people me-1"></i>
                        {{ $team->activeMembers->count() }} membro(s) ativo(s)
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-calendar me-1"></i>
                        Criado em {{ $team->created_at->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Membros --}}
        <div class="col-md-8">
            <div class="card-mp mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-people me-2" style="color:#a78bfa;"></i>Membros
                    </h5>
                    @can('update', $team)
                        <a href="{{ route('team-members.create') }}?team_id={{ $team->id }}"
                           class="btn btn-mp-fill btn-sm">
                            <i class="bi bi-person-plus me-1"></i> Convidar
                        </a>
                    @endcan
                </div>

                @if ($team->activeMembers->isEmpty())
                    <p style="color:#b8aede;">Nenhum membro ativo ainda.</p>
                @else
                    <div class="d-flex flex-column gap-2">
                        @foreach ($team->activeMembers as $member)
                            <div class="d-flex justify-content-between align-items-center p-3 rounded"
                                 style="background:rgba(124,58,237,0.08); border:1px solid rgba(124,58,237,0.2);">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="user-badge">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </span>
                                    <div>
                                        <span class="fw-bold">{{ $member->name }}</span>
                                        @if ($member->id === $team->owner_id)
                                            <small class="d-block" style="color:#a78bfa;">
                                                <i class="bi bi-star-fill me-1"></i>Dono
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                @can('delete', $team)
                                    @if ($member->id !== $team->owner_id)
                                        <form action="{{ route('team-members.destroy', $member->pivot->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm"
                                                    style="border:1px solid rgba(239,68,68,0.4); color:#fca5a5; background:rgba(239,68,68,0.08);"
                                                    onclick="return confirm('Remover este membro do time?')">
                                                <i class="bi bi-person-x"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endcan
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Torneios do time --}}
            <div class="card-mp">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-trophy me-2" style="color:#a78bfa;"></i>Torneios
                </h5>

                @if ($team->tournaments->isEmpty())
                    <p style="color:#b8aede;">Este time ainda não participou de nenhum torneio.</p>
                @else
                    <div class="d-flex flex-column gap-2">
                        @foreach ($team->tournaments as $tournament)
                            <div class="d-flex justify-content-between align-items-center p-3 rounded"
                                 style="background:rgba(124,58,237,0.08); border:1px solid rgba(124,58,237,0.2);">
                                <div>
                                    <span class="fw-bold">{{ $tournament->name }}</span>
                                    <small class="d-block" style="color:#b8aede;">
                                        {{ $tournament->game->name }} •
                                        {{ $tournament->mode === 'solo' ? '1v1' : 'Times' }}
                                    </small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="px-2 py-1 rounded"
                                          style="font-size:0.75rem; background:rgba(124,58,237,0.2); color:#a78bfa;">
                                        {{ ucfirst($tournament->status) }}
                                    </span>
                                    <a href="{{ route('tournaments.show', $tournament->id) }}"
                                       class="btn btn-mp-outline btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection