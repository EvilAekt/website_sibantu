<nav class="navbar">
    <div class="container">
        <div class="nav-brand">
            <i class="fas fa-hands-helping"></i>
            <span>Bantuan Masyarakat</span>
        </div>

        <ul class="nav-menu">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ route('laporan.create') }}" class="{{ request()->routeIs('laporan.create') ? 'active' : '' }}">Laporkan</a></li>
            <li><a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.index') ? 'active' : '' }}">Daftar Bantuan</a></li>
            <li><a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang Kami</a></li>

            @auth
                <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}" class="btn-login">Login</a></li>
            @endauth
        </ul>
    </div>
</nav>
