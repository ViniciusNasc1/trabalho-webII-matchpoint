@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-person-plus me-2" style="color:#a78bfa;"></i>Convidar Membro
        </h4>
        <a href="{{ route('teams.index') }}" class="btn btn-mp-outline">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-mp">
                <form action="{{ route('team-members.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="team_id" value="{{ request('team_id') }}">
                    <input type="hidden" name="status" value="invited">

                    <div class="mb-4">
                        <label for="user_id">Usuário</label>
                        <select id="user_id" name="user_id">
                            <option value="">Selecione um usuário</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} — {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-mp-fill w-100">
                        <i class="bi bi-person-plus me-1"></i> Convidar
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection