<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group mb-3">
            <label for="email" class="form-label text-secondary">Email Address</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required
                autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
        </div>

        <!-- Password -->
        <div class="form-group mb-3">
            <label for="password" class="form-label text-secondary">Password</label>
            <input id="password" type="password" name="password" class="form-control" required
                autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
        </div>

        <!-- Remember Me -->
        <div class="form-check mb-3">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label text-secondary text-sm">Remember me</label>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-block py-2">
                Log in
            </button>
        </div>

        @if (Route::has('password.request'))
            <div class="text-center mt-3">
                <a class="small text-muted" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>