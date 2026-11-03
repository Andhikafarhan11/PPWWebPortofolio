<x-guest-layout>
    {{-- Pesan Status Session --}}
    @if (session('status'))
        <div class="alert alert-success small mb-3">
            {{ session('status') }}
        </div>
    @endif

    {{-- Pesan Error Validasi Login --}}
    @if ($errors->any())
        <div class="alert alert-danger small py-2 mb-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Input Email --}}
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold small text-secondary">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" 
                   class="form-control @error('email') is-invalid @enderror" 
                   placeholder="admin@example.com" required autofocus autocomplete="username">
        </div>

        {{-- Input Password --}}
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold small text-secondary">Password</label>
            <input id="password" type="password" name="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   placeholder="••••••••" required autocomplete="current-password">
        </div>

        {{-- Remember Me & Forgot Password --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label small text-secondary">Remember me</label>
            </div>

            @if (Route::has('password.request'))
                <a class="small text-decoration-none" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        {{-- Tombol Submit Login --}}
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary fw-semibold py-2">
                Log in
            </button>
            <a href="{{ route('home') }}" class="btn btn-light btn-sm text-secondary mt-1">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </form>
</x-guest-layout>