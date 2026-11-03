<nav style="background-color: #333; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
    {{-- Menu Navigasi Kiri --}}
    <div>
        <a href="{{ route('home') }}" style="color: white; margin-right: 15px; text-decoration: none;">Home</a>
        <a href="{{ route('about') }}" style="color: white; margin-right: 15px; text-decoration: none;">About</a>
        <a href="{{ route('education') }}" style="color: white; margin-right: 15px; text-decoration: none;">Education</a>
        <a href="{{ route('projects.index') }}" style="color: white; margin-right: 15px; text-decoration: none;">Projects</a>

        @auth
            <a href="{{ url('/post/profile-saya') }}" style="color: white; text-decoration: none;">Profile Saya</a>
        @endauth
    </div>

    {{-- Informasi User & Tombol Login/Logout Kanan --}}
    <div style="display: flex; align-items: center; gap: 15px;">
        @auth
            <span style="color: #cbd5e1; font-size: 14px;">
                Halo, <strong style="color: white;">{{ Auth::user()->name }}</strong>
            </span>

            <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                @csrf
                <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 14px;">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" style="background-color: #0d6efd; color: white; padding: 6px 14px; border-radius: 4px; text-decoration: none; font-size: 14px;">
                Login
            </a>
        @endauth
    </div>
</nav>