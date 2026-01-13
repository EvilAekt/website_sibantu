<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - SiBantu')</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif']
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
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'glow': '0 0 15px rgba(59, 130, 246, 0.5)'
                    }
                }
            }
        }
    </script>

    @php
        $role = auth()->user()->role ?? 'guest';
        $theme = [
            'admin' => [
                'aside' => 'bg-[#0f172a] text-slate-400 border-r border-[#1e293b]',
                'logo_box' => 'bg-blue-600 text-white',
                'active_link' => 'bg-blue-600 text-white shadow-lg shadow-blue-500/30', // Solid Blue
                'hover_link' => 'hover:bg-[#1e293b] hover:text-white',
                'text_muted' => 'text-slate-500',
                'user_box' => 'bg-[#1e293b]/50 border-[#334155]',
            ],
            'fundraiser' => [
                'aside' => 'bg-blue-900 text-blue-200 border-r border-blue-800',
                'logo_box' => 'bg-white text-blue-700 shadow-lg',
                'active_link' => 'bg-blue-700 text-white shadow-md', // Distinct Blue
                'hover_link' => 'hover:bg-blue-800 hover:text-white',
                'text_muted' => 'text-blue-300',
                'user_box' => 'bg-blue-800/30 border-blue-700/50',
            ],
            'donatur' => [
                'aside' => 'bg-white dark:bg-gray-900 text-gray-500 dark:text-gray-400 border-r border-gray-100 dark:border-gray-800',
                'logo_box' => 'bg-blue-600 text-white shadow-lg shadow-blue-500/30',
                'active_link' => 'bg-blue-600 text-white shadow-lg shadow-blue-500/30', // Solid Blue
                'hover_link' => 'hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white',
                'text_muted' => 'text-gray-400',
                'user_box' => 'bg-gray-50 dark:bg-gray-800 border-gray-100 dark:border-gray-700',
            ]
        ][$role] ?? [
            'aside' => 'bg-white border-r border-gray-100',
            'logo_box' => 'bg-blue-600 text-white',
            'active_link' => 'bg-blue-600 text-white',
            'hover_link' => 'hover:bg-gray-50',
            'text_muted' => 'text-gray-400',
            'user_box' => 'bg-gray-50',
        ];
    @endphp

    <style>
        [x-cloak] {
            display: none !important;
        }

        .sidebar-link {
            @apply flex items-center gap-4 px-4 py-3 mb-2 rounded-xl transition-all duration-200 mx-3 font-semibold text-[15px] group;
        }

        /* Theme Application */
        .app-sidebar {
            @apply
            {{ $theme['aside'] }}
            ;
        }

        .sidebar-link.active {
            @apply
            {{ $theme['active_link'] }}
            ;
        }

        .sidebar-link:not(.active) {
            @apply
            {{ $theme['hover_link'] }}
            ;
        }

        .sidebar-link i {
            @apply w-6 text-center text-lg transition-transform duration-300;
        }

        .sidebar-link:hover i {
            @apply scale-110;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            @apply bg-gray-300/50 dark:bg-gray-600/50 rounded-full;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#f8fafc] dark:bg-[#0b1120] text-gray-900 dark:text-gray-100 antialiased font-sans" x-data="{ 
        sidebarOpen: window.innerWidth >= 1024,
        mobileMenuOpen: false,
        darkMode: localStorage.getItem('theme') === 'dark',
        init() {
            if (this.darkMode) document.documentElement.classList.add('dark');
            this.$watch('darkMode', val => {
                localStorage.setItem('theme', val ? 'dark' : 'light');
                document.documentElement.classList.toggle('dark', val);
            });
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) this.sidebarOpen = true;
                else this.sidebarOpen = false;
            });
        }
    }">

    <div class="min-h-screen flex">
        <!-- Sidebar (Premium Design) -->
        <aside :class="sidebarOpen ? 'w-[280px]' : 'w-[88px]'"
            class="fixed inset-y-0 left-0 z-40 transition-all duration-300 hidden lg:flex flex-col bg-[#0f172a] text-white shadow-2xl overflow-hidden font-sans border-r border-slate-800">

            <!-- 1. Header Area (Blue Bar) -->
            <div class="h-[70px] bg-blue-700 flex items-center px-6 shadow-md z-10 relative">
                <a href="{{ url('/') }}" class="flex items-center gap-3 w-full overflow-hidden group">
                    <div
                        class="bg-white text-blue-700 w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 shadow-sm">
                        <i class="fas fa-hand-holding-heart text-lg"></i>
                    </div>
                    <div x-show="sidebarOpen" x-transition.opacity.duration.300ms class="flex flex-col">
                        <span class="font-bold text-lg tracking-wide text-white">
                            @if(Auth::user()->role === 'admin')
                                SiBantu Admin
                            @elseif(Auth::user()->role === 'fundraiser')
                                SiBantu Fundraiser
                            @else
                                SiBantu
                            @endif
                        </span>
                    </div>
                </a>
            </div>

            <!-- 2. Profile Section (Centered & Glowing) -->
            <div x-show="sidebarOpen"
                class="flex flex-col items-center justify-center pt-8 pb-6 transition-all duration-300">
                <div class="relative group cursor-pointer">
                    <!-- Glow Effect behind avatar -->
                    <div
                        class="absolute inset-0 bg-blue-500/30 blur-xl rounded-full group-hover:bg-blue-400/50 transition-all duration-500">
                    </div>

                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=128"
                        class="relative w-24 h-24 rounded-full border-4 border-[#1e293b] shadow-2xl object-cover transform group-hover:scale-105 transition-transform duration-300">

                    <!-- Online Status Dot -->
                    <div
                        class="absolute bottom-1 right-1 w-5 h-5 bg-green-500 border-4 border-[#0f172a] rounded-full z-10">
                    </div>
                </div>

                <!-- Email Pill -->
                <div class="mt-4 bg-[#1e293b] py-1.5 px-4 rounded-full border border-slate-700/50 shadow-sm">
                    <p class="text-xs text-slate-400 font-medium tracking-wide">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Separator for minimized mode -->
            <div x-show="!sidebarOpen" class="h-8"></div>

            <!-- Navigation -->
            <!-- Navigation (Clean & Simplified) -->
            <nav class="flex-1 px-4 space-y-2 overflow-y-auto pt-4">
                @php
                    $menuItem = function ($route, $icon, $label, $color = 'text-blue-400', $badge = null) {
                        $active = request()->routeIs($route) || request()->routeIs($route . '*');

                        // Active: Bright Blue Gradient + Strong Glow
                        $activeClass = 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-[0_0_15px_rgba(37,99,235,0.5)] border border-blue-400/20';

                        // Inactive: Transparent + Hover Effect
                        $inactiveClass = 'hover:bg-white/5 text-slate-400 hover:text-white transition-all duration-200';

                        // Icon Color (Only when inactive)
                        $iconColor = $active ? 'text-white' : $color;

                        echo '<a href="' . route($route) . '" 
                                                                                                                                                        class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 group relative ' . ($active ? $activeClass : $inactiveClass) . '">

                                                                                                                                                        <div class="w-6 flex justify-center flex-shrink-0 text-[18px] ' . $iconColor . '">
                                                                                                                                                            <i class="' . $icon . '"></i>
                                                                                                                                                        </div>

                                                                                                                                                        <span x-show="sidebarOpen" class="font-medium text-[15px] tracking-wide">' . $label . '</span>';

                        if ($badge) {
                            echo '<span x-show="sidebarOpen" class="absolute right-3 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">' . $badge . '</span>';
                        }

                        echo '</a>';
                    };
                @endphp

                @auth
                    {{-- ADMIN MENU --}}
                    @if(Auth::user()->role === 'admin')
                        {{ $menuItem('admin.dashboard', 'fas fa-th-large', 'Overview', 'text-blue-400') }}
                        {{ $menuItem('admin.reports', 'fas fa-file-alt', 'Laporan', 'text-yellow-400', '64') }}
                        {{ $menuItem('profile.edit', 'fas fa-cog', 'Pengaturan', 'text-slate-400') }}

                        {{-- FUNDRAISER MENU --}}
                    @elseif(Auth::user()->role === 'fundraiser')
                        {{ $menuItem('fundraiser.dashboard', 'fas fa-chart-pie', 'Ringkasan', 'text-blue-400') }}
                        {{ $menuItem('fundraiser.campaigns.create', 'fas fa-plus-circle', 'Buat Kampanye', 'text-green-400') }}
                        {{ $menuItem('fundraiser.dashboard', 'fas fa-list', 'Semua Kampanye', 'text-purple-400') }}
                        {{ $menuItem('profile.edit', 'fas fa-cog', 'Pengaturan', 'text-slate-400') }}

                        {{-- DONATUR MENU --}}
                    @else
                        {{ $menuItem('user.dashboard', 'fas fa-home', 'Beranda', 'text-blue-400') }}
                        {{ $menuItem('user.history', 'fas fa-history', 'Riwayat Donasi', 'text-yellow-400') }}
                        {{ $menuItem('campaigns.index', 'fas fa-search', 'Cari Program', 'text-pink-400') }}
                        {{ $menuItem('profile.edit', 'fas fa-cog', 'Pengaturan', 'text-slate-400') }}
                    @endif

                    <!-- Logout Section (Always at bottom) -->
                    <div class="flex-1"></div>

                    <a href="{{ url('/') }}"
                        class="w-full flex items-center gap-4 px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-all duration-300 group mb-2">
                        <div class="w-6 flex justify-center flex-shrink-0"><i class="fas fa-arrow-left"></i></div>
                        <span x-show="sidebarOpen" class="font-medium">Kembali ke Beranda</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="mb-4 pt-4 border-t border-slate-700/50 mt-4">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-4 px-4 py-3 text-red-400 hover:text-white hover:bg-red-500/20 rounded-xl transition-all duration-300 group">
                            <div class="w-6 flex justify-center flex-shrink-0"><i class="fas fa-sign-out-alt"></i></div>
                            <span x-show="sidebarOpen" class="font-medium">Keluar</span>
                        </button>
                    </form>
                @endauth
            </nav>
            <div class="h-4"></div>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="mobileMenuOpen" x-cloak class="fixed inset-0 z-50 lg:hidden user-select-none">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                @click="mobileMenuOpen = false"></div>

            <aside
                class="fixed inset-y-0 left-0 w-[280px] app-sidebar shadow-2xl transition-transform duration-300 flex flex-col"
                x-transition:enter="translate-x-0" x-transition:leave="-translate-x-full">

                <div class="h-24 flex items-center justify-between px-6 border-b border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 {{ $theme['logo_box'] }} rounded-xl flex items-center justify-center">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <span class="font-extrabold text-xl">SiBantu</span>
                    </div>
                    <button @click="mobileMenuOpen = false" class="p-2 opacity-50 hover:opacity-100">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
                    <!-- Simplified Mobile Nav -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 text-white">
                        <i class="fas fa-home w-5 text-center"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('campaigns.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 text-white">
                        <i class="fas fa-heart w-5 text-center"></i>
                        <span class="font-medium">Mulai Donasi</span>
                    </a>
                    <div class="my-4 border-t border-white/10"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-red-500/20 text-red-400 w-full">
                            <i class="fas fa-sign-out-alt w-5 text-center"></i>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </nav>
            </aside>
        </div>

        <!-- Main Content -->
        <div :class="sidebarOpen ? 'lg:pl-[280px]' : 'lg:pl-[88px]'"
            class="flex-1 transition-all duration-300 flex flex-col min-h-screen w-full">

            <!-- Navbar -->
            <header
                class="h-20 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="mobileMenuOpen = true"
                        class="lg:hidden p-2 rounded-xl text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="hidden lg:flex items-center justify-center w-10 h-10 rounded-xl text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition">
                        <i class="fas fa-bars text-lg"></i>
                    </button>

                    <div class="hidden md:block h-6 w-px bg-gray-300 dark:bg-gray-700 mx-2"></div>

                    <div class="opacity-0 md:opacity-100 transition-opacity">
                        @hasSection('header')
                            @yield('header')
                        @else
                            <h2 class="text-lg font-bold text-gray-800 dark:text-white">Dashboard</h2>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button @click="darkMode = !darkMode"
                        class="w-10 h-10 rounded-xl flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 dark:text-gray-400 transition"
                        title="Toggle Dark Mode">
                        <i x-show="!darkMode" class="fas fa-moon"></i>
                        <i x-show="darkMode" class="fas fa-sun text-yellow-400"></i>
                    </button>

                    <div class="h-8 w-px bg-gray-200 dark:bg-gray-700 mx-2 hidden md:block"></div>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center gap-3 hover:bg-gray-50 dark:hover:bg-gray-800/50 p-1.5 pr-3 rounded-full border border-transparent hover:border-gray-200 dark:hover:border-gray-700 transition">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                                class="w-8 h-8 rounded-full ring-2 ring-white dark:ring-gray-800 shadow-sm">
                            <span
                                class="hidden md:block text-sm font-bold text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400 ml-1 hidden md:block"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak
                            class="absolute right-0 mt-3 w-56 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 py-2 origin-top-right ring-1 ring-black ring-opacity-5 focus:outline-none transform transition ease-out duration-100"
                            x-transition:enter="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95">

                            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 mb-2">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <i class="fas fa-home w-4 text-gray-400"></i> Dashboard
                            </a>

                            <a href="{{ url('/') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <i class="fas fa-globe w-4 text-gray-400"></i> Beranda
                            </a>

                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <i class="fas fa-user-circle w-4 text-gray-400"></i> Profile
                            </a>

                            <div class="my-1 border-t border-gray-100 dark:border-gray-700"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10">
                                    <i class="fas fa-sign-out-alt w-4"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 lg:p-8 w-full max-w-[1600px] mx-auto">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition
                        class="mb-6 p-4 bg-green-50 dark:bg-green-900/10 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-green-500 hover:text-green-700"><i
                                class="fas fa-times"></i></button>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition
                        class="mb-6 p-4 bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-xl flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-exclamation"></i>
                            </div>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-red-500 hover:text-red-700"><i
                                class="fas fa-times"></i></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>