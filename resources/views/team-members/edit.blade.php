@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-person-gear me-2" style="color:#a78bfa;"></i>Atualizar Membro
        </h4>
        <a href="{{ route('teams.show', $member->team_id) }}" class="btn btn-mp-outline">
            <i class="bi bi-arrow-left me-1"></i> Voltar ao time
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">

            {{-- Info do membro --}}
            <div class="card-mp mb-4">
                <div class="d-flex align-items-center gap-3">
                    <span class="user-badge">
                        {{ strtoupper(substr($member->user->name, 0, 1)) }}
                    </span>
                    <div>
                        <p class="fw-bold mb-0">{{ $member->user->name }}</p>
                        <small class="info-text">{{ $member->user->email }}</small>
                    </div>
                </div>

                <div class="mt-3">
                    <p class="info-text mb-1">
                        <i class="bi bi-people me-2"></i>
                        Time: {{ $member->team->name }}
                    </p>
                    <p class="info-text mb-0">
                        <i class="bi bi-calendar me-2"></i>
                        Entrou em: {{ $member->joined_at?->format('d/m/Y') ?? 'Pendente' }}
                    </p>
                </div>
            </div>

            {{-- Formulário --}}
            <div class="card-mp">
                <form action="{{ route('team-members.update', $member->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="status">Status do membro</label>
                        <select id="status" name="status">
                            <option value="invited"
                                {{ old('status', $member->status) === 'invited' ? 'selected' : '' }}>
                                Convidado
                            </option>
                            <option value="active"
                                {{ old('status', $member->status) === 'active' ? 'selected' : '' }}>
                                Ativo
                            </option>
                            <option value="removed"
                                {{ old('status', $member->status) === 'removed' ? 'selected' : '' }}>
                                Removido
                            </option>
                        </select>
                        @error('status')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-mp-fill w-100">
                        <i class="bi bi-check-circle me-1"></i> Salvar alterações
                    </button>
                </form>

                @can('delete', $member)
                    <form action="{{ route('team-members.destroy', $member->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-mp w-100"
                                onclick="return confirm('Remover este membro do time?')">
                            <i class="bi bi-person-x me-1"></i> Remover do time
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>

@endsection