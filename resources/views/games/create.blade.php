@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-plus-circle me-2" style="color:#a78bfa;"></i>Cadastrar Jogo
        </h4>
        <a href="{{ route('games.index') }}" class="btn btn-mp-outline">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-mp">
                <form action="{{ route('games.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name">Nome do jogo</label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name') }}"
                               placeholder="Ex: Counter-Strike 2">
                        @error('name')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="platform">Plataforma</label>
                        <input type="text" id="platform" name="platform"
                               value="{{ old('platform') }}"
                               placeholder="Ex: PC, PS5, Xbox">
                        @error('platform')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image_url">URL da imagem <span style="color:#b8aede;">(opcional)</span></label>
                        <input type="url" id="image_url" name="image_url"
                               value="{{ old('image_url') }}"
                               placeholder="https://...">
                        @error('image_url')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-mp-fill w-100">
                        <i class="bi bi-check-circle me-1"></i> Cadastrar
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection