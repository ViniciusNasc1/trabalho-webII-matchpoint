<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name">Nome</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <p class="text-danger small mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <p class="text-danger small mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password">Senha</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <p class="text-danger small mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Confirmar senha</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
            @error('password_confirmation')
                <p class="text-danger small mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-mp-fill w-100 py-2">Cadastrar</button>

        <p class="text-center mt-3" style="color:#c4b8e8; font-size:0.9rem;">
            Já tem conta? <a href="{{ route('login') }}">Entrar</a>
        </p>
    </form>
</x-guest-layout>