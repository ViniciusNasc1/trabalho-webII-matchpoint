@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-plus-circle me-2" style="color:#a78bfa;"></i>Criar Time
        </h4>
        <a href="{{ route('teams.index') }}" class="btn btn-mp-outline">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-mp">
                <form action="{{ route('teams.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name">Nome do time</label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name') }}"
                               placeholder="Ex: Team Liquid">
                        @error('name')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tag">Tag <span style="color:#b8aede;">(máx. 10 caracteres)</span></label>
                        <input type="text" id="tag" name="tag"
                               value="{{ old('tag') }}"
                               placeholder="Ex: TL, LOUD, FAZE"
                               maxlength="10">
                        @error('tag')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="logo_url">URL do logo <span style="color:#b8aede;">(opcional)</span></label>
                        <input type="url" id="logo_url" name="logo_url"
                               value="{{ old('logo_url') }}"
                               placeholder="https://...">
                        @error('logo_url')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-mp-fill w-100">
                        <i class="bi bi-check-circle me-1"></i> Criar time
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection