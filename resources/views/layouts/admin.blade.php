<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | SiBantu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { primary: '#1e3a8a', secondary: '#3b82f6' },
                    animation: { 'float': 'float 3s ease-in-out infinite' },
                    keyframes: { float: { '0%, 100%': { transform: 'translateY(0px)' }, '50%': { transform: 'translateY(-5px)' } } }
                }
            }
        }
    </script>
    <style>
        .glass-card { backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300"
      x-data="{ sidebarOpen: false, darkMode: localStorage.getItem('theme') === 'dark', toggleDark() { this.darkMode = !this.darkMode; localStorage.setItem('theme', this.darkMode ? 'dark' : 'light'); if(this.darkMode) document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark'); } }"
      x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')); if(darkMode) document.documentElement.classList.add('dark');">

    <header class="bg-gradient-to-r from-primary to-blue-600 dark:from-gray-800 dark:to-gray-900 text-white shadow-lg fixed w-full z-50 transition-colors duration-300">
        <div class="flex items-center justify-between px-4 py-3">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 hover:bg-white/10 rounded transition"><i class="fas fa-bars text-xl"></i></button>
                <div class="flex items-center gap-2">
                    <div class="bg-white p-2 rounded-full shadow-inner"><i class="fas fa-hand-holding-heart text-primary text-lg"></i></div>
                    <span class="font-bold text-lg tracking-wide hidden md:block">SiBantu Admin</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button @click="toggleDark()" class="p-2 rounded-full hover:bg-white/10 transition transform hover:rotate-12"><i class="fas" :class="darkMode ? 'fa-sun text-yellow-300' : 'fa-moon'"></i></button>
                <div class="flex items-center gap-3 bg-white/10 px-3 py-1 rounded-full border border-white/20">
                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-primary font-bold">A</div>
                    <div class="hidden sm:block text-left"><div class="text-sm font-bold leading-tight">{{ Auth::user()->name ?? 'Admin' }}</div></div>
                </div>
            </div>
        </div>
    </header>

    <aside class="fixed left-0 top-0 h-full bg-gray-800 dark:bg-gray-950 text-white w-64 transform transition-transform duration-300 z-40 pt-20 border-r border-gray-700"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
        <div class="p-4">
            <div class="flex flex-col items-center mb-8 pb-6 border-b border-gray-700 animate-float">
                <div class="w-20 h-20 rounded-full bg-blue-500 flex items-center justify-center text-3xl font-bold border-4 border-secondary shadow-lg mb-3">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <h3 class="font-bold text-center">{{ Auth::user()->name ?? 'Administrator' }}</h3>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-secondary shadow-lg text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                    <i class="fas fa-home w-5"></i> <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('laporan.*') ? 'bg-secondary shadow-lg text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                    <i class="fas fa-file-alt w-5"></i> <span class="font-medium">Laporan Masuk</span>
                </a>
                
                {{-- MENU BARU --}}
                <a href="{{ route('admin.bantuan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.bantuan') ? 'bg-secondary shadow-lg text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                    <i class="fas fa-box w-5"></i> <span class="font-medium">Data Bantuan</span>
                </a>
                <a href="{{ route('admin.penyaluran') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.penyaluran') ? 'bg-secondary shadow-lg text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                    <i class="fas fa-truck w-5"></i> <span class="font-medium">Penyaluran</span>
                </a>
                <a href="{{ route('admin.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.pengaturan') ? 'bg-secondary shadow-lg text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                    <i class="fas fa-cog w-5"></i> <span class="font-medium">Pengaturan</span>
                </a>
            </nav>
        </div>
    </aside>

    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden glass-card"></div>

    <main class="lg:ml-64 pt-20 p-6 min-h-screen">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>
</body>
</html>