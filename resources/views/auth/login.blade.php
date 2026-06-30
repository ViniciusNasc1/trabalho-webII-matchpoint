<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
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

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember" style="color:#c4b8e8; font-size:0.85rem;">
                    Lembrar
                </label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Esqueceu a senha?</a>
            @endif
        </div>

        <button type="submit" class="btn btn-mp-fill w-100 py-2">Entrar</button>

        <p class="text-center mt-3" style="color:#c4b8e8; font-size:0.9rem;">
            Não tem conta? <a href="{{ route('register') }}">Cadastre-se</a>
        </p>
    </form>
</x-guest-layout>