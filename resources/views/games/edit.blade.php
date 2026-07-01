@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-pencil me-2" style="color:#a78bfa;"></i>Editar Jogo
        </h4>
        <a href="{{ route('games.show', $game->id) }}" class="btn btn-mp-outline">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-mp">
                <form action="{{ route('games.update', $game->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name">Nome do jogo</label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name', $game->name) }}"
                               placeholder="Ex: Counter-Strike 2">
                        @error('name')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="platform">Plataforma</label>
                        <input type="text" id="platform" name="platform"
                               value="{{ old('platform', $game->platform) }}"
                               placeholder="Ex: PC, PS5, Xbox">
                        @error('platform')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image_url">URL da imagem <span style="color:#b8aede;">(opcional)</span></label>
                        <input type="url" id="image_url" name="image_url"
                               value="{{ old('image_url', $game->image_url) }}"
                               placeholder="https://...">
                        @error('image_url')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-mp-fill w-100">
                        <i class="bi bi-check-circle me-1"></i> Salvar alterações
                    </button>
                </form>

                @can('delete', $game)
                    <form action="{{ route('games.destroy', $game->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn w-100"
                                style="border:1px solid rgba(239,68,68,0.4); color:#fca5a5; background:rgba(239,68,68,0.08);"
                                onclick="return confirm('Tem certeza que deseja remover este jogo?')">
                            <i class="bi bi-trash me-1"></i> Remover jogo
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>

@endsection