@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-people-fill me-2" style="color:#a78bfa;"></i>Times
        </h4>
        @can('create', App\Models\Team::class)
            <a href="{{ route('teams.create') }}" class="btn btn-mp-fill">
                <i class="bi bi-plus-circle me-1"></i> Criar time
            </a>
        @endcan
    </div>

    @if ($data->isEmpty())
        <div class="card-mp text-center py-5">
            <i class="bi bi-people" style="font-size:3rem; color:#a78bfa;"></i>
            <p class="mt-3" style="color:#c4b8e8;">Nenhum time cadastrado ainda.</p>
            @can('create', App\Models\Team::class)
                <a href="{{ route('teams.create') }}" class="btn btn-mp-fill mt-2">
                    Criar primeiro time
                </a>
            @endcan
        </div>
    @else
        <div class="row g-4">
            @foreach ($data as $team)
                <div class="col-md-4">
                    <div class="card-mp h-100 d-flex flex-column justify-content-between">
                        <div>
                            @if ($team->logo_url)
                                <img src="{{ $team->logo_url }}" alt="{{ $team->name }}"
                                     class="img-fluid rounded mb-3"
                                     style="max-height:100px; object-fit:cover; width:100%;">
                            @else
                                <div class="d-flex align-items-center justify-content-center rounded mb-3"
                                     style="height:100px; background:rgba(124,58,237,0.15);">
                                    <i class="bi bi-people" style="font-size:2.5rem; color:#a78bfa;"></i>
                                </div>
                            @endif

                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h3 class="mb-0">{{ $team->name }}</h3>
                                <span class="px-2 py-1 rounded"
                                      style="font-size:0.75rem; background:rgba(124,58,237,0.2); color:#a78bfa;">
                                    {{ $team->tag }}
                                </span>
                            </div>

                            <small style="color:#b8aede;">
                                <i class="bi bi-person me-1"></i>
                                Dono: {{ $team->owner->name }}
                            </small>

                            <p class="mt-2 mb-0" style="color:#b8aede; font-size:0.85rem;">
                                <i class="bi bi-people me-1"></i>
                                {{ $team->activeMembers->count() }} membro(s)
                            </p>
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('teams.show', $team->id) }}" class="btn btn-mp-outline w-100">
                                <i class="bi bi-eye me-1"></i> Ver
                            </a>
                            @can('update', $team)
                                <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-mp-fill w-100">
                                    <i class="bi bi-pencil me-1"></i> Editar
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection