<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bantuan Masyarakat')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <i class="fas fa-hands-helping"></i>
                <span>Bantuan Masyarakat</span>
            </div>
            <button class="nav-toggle" id="navToggle">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('laporan.create') }}" class="{{ request()->routeIs('laporan.create') ? 'active' : '' }}">Laporkan</a></li>
                <li><a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.index') ? 'active' : '' }}">Daftar Bantuan</a></li>
                <li><a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang Kami</a></li>

                @auth
                    <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
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

    @if(session('success'))
        <div class="alert alert-success" id="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error" id="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><i class="fas fa-hands-helping"></i> Bantuan Masyarakat</h3>
                    <p>Platform pelaporan dan penyaluran bantuan untuk masyarakat yang membutuhkan.</p>
                </div>
                <div class="footer-section">
                    <h4>Kontak</h4>
                    <p><i class="fas fa-phone"></i> +62 812-3456-7890</p>
                    <p><i class="fas fa-envelope"></i> info@bantuan.com</p>
                </div>
                <div class="footer-section">
                    <h4>Ikuti Kami</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Bantuan Masyarakat. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>