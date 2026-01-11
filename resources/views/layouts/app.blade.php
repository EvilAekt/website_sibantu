<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiBantu - Platform Bantuan Masyarakat')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { 
                        sans: ['Inter', 'system-ui', 'sans-serif'] 
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        
        /* Smooth transitions untuk semua elemen */
        * {
            @apply transition-colors duration-200;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            @apply bg-gray-100 dark:bg-gray-800;
        }
        ::-webkit-scrollbar-thumb {
            @apply bg-gray-400 dark:bg-gray-600 rounded-full;
        }
        ::-webkit-scrollbar-thumb:hover {
            @apply bg-gray-500 dark:bg-gray-500;
        }

        /* Glass effect untuk card */
        .glass-card {
            @apply bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border border-gray-200/50 dark:border-gray-700/50;
        }

        /* Button hover effect */
        .btn-primary {
            @apply bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col antialiased"
      x-data="{ 
          darkMode: false,
          mobileOpen: false,
          userDropdown: false,
          init() {
              // Cek preferensi user dari localStorage
              const theme = localStorage.getItem('theme');
              const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
              
              this.darkMode = theme === 'dark' || (!theme && prefersDark);
              this.applyTheme();
              
              // Watch perubahan
              this.$watch('darkMode', () => this.applyTheme());
          },
          applyTheme() {
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
                  localStorage.setItem('theme', 'dark');
              } else {
                  document.documentElement.classList.remove('dark');
                  localStorage.setItem('theme', 'light');
              }
          }
      }">

    <!-- Navbar -->
    <nav class="fixed w-full top-0 z-50 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-200/50 dark:border-gray-800/50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="bg-primary-600 p-2 rounded-xl shadow-md group-hover:shadow-lg group-hover:scale-105 transition-all">
                        <i class="fas fa-hand-holding-heart text-white text-xl"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text ">
                        SiBantu
                    </span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ Route::has('home') ? route('home') : url('/') }}" 
                    class="text-sm font-medium {{ request()->is('/') ? 'text-primary-600 dark:text-primary-400' : 'text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400' }}">
                        Beranda
                    </a>
                    <a href="{{ Route::has('laporan.create') ? route('laporan.create') : '#' }}" 
                    class="text-sm font-medium {{ request()->routeIs('laporan.create') ? 'text-primary-600 dark:text-primary-400' : 'text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400' }}">
                        Laporkan
                    </a>
                    <a href="{{ Route::has('laporan.index') ? route('laporan.index') : '#' }}" 
                    class="text-sm font-medium {{ request()->routeIs('laporan.index') ? 'text-primary-600 dark:text-primary-400' : 'text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400' }}">
                        Daftar Bantuan
                    </a>
                    <a href="{{ Route::has('tentang') ? route('tentang') : '#' }}" 
                    class="text-sm font-medium {{ request()->routeIs('tentang') ? 'text-primary-600 dark:text-primary-400' : 'text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400' }}">
                        Tentang
                    </a>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" 
                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <i x-show="!darkMode" class="fas fa-moon text-gray-600"></i>
                        <i x-show="darkMode" class="fas fa-sun text-yellow-400"></i>
                    </button>

                    @auth
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 hover:opacity-80 transition">
                                <span class="text-sm font-medium hidden lg:block">{{ Auth::user()->name }}</span>
                                <img src="{{ Auth::user()->foto ? asset('storage/'.Auth::user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=2563eb&color=fff' }}" 
                                     class="h-9 w-9 rounded-full border-2 border-primary-600 shadow-sm">
                            </button>
                            <div x-show="open" 
                                 @click.away="open = false" 
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute right-0 mt-2 w-48 glass-card rounded-xl shadow-xl py-2 z-50">
                                <a href="{{ route('dashboard') }}" 
                                   class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg mx-2">
                                    <i class="fas fa-dashboard w-5"></i> Dashboard
                                </a>
                                <hr class="my-2 border-gray-200 dark:border-gray-700">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg mx-2">
                                        <i class="fas fa-sign-out-alt w-5"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" 
                           class="btn-primary text-sm">
                            Login
                        </a>
                    @endauth

                    <!-- Mobile Menu Toggle -->
                    <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                        <i class="fas" :class="mobileOpen ? 'fa-times' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" 
         x-cloak
         @click.away="mobileOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-lg absolute w-full left-0">
        
        <div class="px-4 py-3 space-y-1">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-lg font-medium {{ request()->is('/') ? 'bg-primary-50 text-primary-600 dark:bg-gray-800 dark:text-primary-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                Beranda
            </a>
            <a href="{{ Route::has('laporan.create') ? route('laporan.create') : '#' }}" class="block px-3 py-2 rounded-lg font-medium {{ request()->routeIs('laporan.create') ? 'bg-primary-50 text-primary-600 dark:bg-gray-800 dark:text-primary-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                Laporkan
            </a>
            <a href="{{ Route::has('laporan.index') ? route('laporan.index') : '#' }}" class="block px-3 py-2 rounded-lg font-medium {{ request()->routeIs('laporan.index') ? 'bg-primary-50 text-primary-600 dark:bg-gray-800 dark:text-primary-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                Daftar Bantuan
            </a>
            <a href="{{ Route::has('tentang') ? route('tentang') : '#' }}" class="block px-3 py-2 rounded-lg font-medium {{ request()->routeIs('tentang') ? 'bg-primary-50 text-primary-600 dark:bg-gray-800 dark:text-primary-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                Tentang
            </a>

            <div class="border-t border-gray-200 dark:border-gray-700 mt-2 pt-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg font-medium text-white bg-primary-600 hover:bg-primary-700 text-center">
                        Dashboard
                    </a>
                @else
                    <div class="grid grid-cols-2 gap-2 mt-2">
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg font-medium text-center border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800">
                            Masuk
                        </a>
                        <a href="{{ route('register.relawan') }}" class="block px-3 py-2 rounded-lg font-medium text-center text-white bg-primary-600 hover:bg-primary-700">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
<footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 pt-16 pb-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Grid Utama 4 Kolom --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                
                {{-- Kolom 1: Brand & Deskripsi --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <div class="bg-blue-600 p-2 rounded-lg text-white">
                            <i class="fas fa-hand-holding-heart text-lg"></i>
                        </div>
                        <span class="font-bold text-xl text-gray-900 dark:text-white tracking-wide">SiBantu</span>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        Platform digital untuk transparansi pelaporan dan penyaluran bantuan sosial. Mari bersama wujudkan Indonesia yang lebih peduli.
                    </p>
                    {{-- Social Media Icons --}}
                    <div class="flex gap-4 pt-2">
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 transition-all duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-blue-400 hover:text-white dark:hover:bg-blue-400 transition-all duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-pink-600 hover:text-white dark:hover:bg-pink-600 transition-all duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.tiktok.com/@evil_aekt" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-all duration-300">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>

                {{-- Kolom 2: Navigasi --}}
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-6">Navigasi Cepat</h3>
                    <ul class="space-y-3 text-sm text-gray-500 dark:text-gray-400">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center gap-2">
                                <i class="fas fa-chevron-right text-xs"></i> Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('laporan.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center gap-2">
                                <i class="fas fa-chevron-right text-xs"></i> Daftar Bantuan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('laporan.create') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center gap-2">
                                <i class="fas fa-chevron-right text-xs"></i> Buat Laporan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tentang') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center gap-2">
                                <i class="fas fa-chevron-right text-xs"></i> Tentang Kami
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Kolom 3: Informasi --}}
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-6">Informasi</h3>
                    <ul class="space-y-3 text-sm text-gray-500 dark:text-gray-400">
                        <li>
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Cara Melapor</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Syarat & Ketentuan</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Kebijakan Privasi</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">FAQ</a>
                        </li>
                    </ul>
                </div>

                {{-- Kolom 4: Kontak --}}
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-6">Hubungi Kami</h3>
                    <ul class="space-y-4 text-sm text-gray-500 dark:text-gray-400">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-blue-600 mt-1"></i>
                            <span>Jl.Utara No 1, Kelurahan Sumber, Kecamatan Banjarsari, Kota Surakarta Solo, Jawa Tengah, Indonesia</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-blue-600"></i>
                            <span>support@sibantu.id</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-blue-600"></i>
                            <span>+62 812-2600-960</span>
                        </li>
                    </ul>
                </div>

            </div>

            {{-- Copyright Section --}}
            <div class="border-t border-gray-200 dark:border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center md:text-left">
                    &copy; {{ date('Y') }} <span class="font-bold text-blue-600">SiBantu</span>. All rights reserved.
                </p>
                <p class="text-sm text-gray-400 flex items-center gap-1">
                    Made with for Evil_Aekt
                </p>
            </div>

        </div>
    </footer>

    @stack('scripts')
</body>
</html>