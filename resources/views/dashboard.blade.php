<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | SiBantu</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a8a', // Blue-900 base
                        secondary: '#3b82f6', // Blue-500 base
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-pulse-slow { animation: pulse-slow 2s ease-in-out infinite; }
        
        /* Glass effect */
        .glass-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300"
      x-data="{ 
          sidebarOpen: window.innerWidth >= 1024, 
          darkMode: localStorage.getItem('theme') === 'dark',
          toggleDark() {
              this.darkMode = !this.darkMode;
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
                  localStorage.setItem('theme', 'dark');
              } else {
                  document.documentElement.classList.remove('dark');
                  localStorage.setItem('theme', 'light');
              }
          }
      }"
      x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')); if(darkMode) document.documentElement.classList.add('dark');"
>

    <header class="bg-gradient-to-r from-primary to-blue-600 dark:from-gray-800 dark:to-gray-900 text-white shadow-lg fixed w-full z-50 transition-colors duration-300">
        <div class="flex items-center justify-between px-4 py-3">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-white/10 rounded transition focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <div class="flex items-center gap-2">
                    <div class="bg-white p-2 rounded-full shadow-inner">
                        <i class="fas fa-hand-holding-heart text-primary text-lg"></i>
                    </div>
                    <span class="font-bold text-lg tracking-wide hidden md:block">SiBantu Admin</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                
                {{-- TOMBOL KEMBALI KE BERANDA (BARU) --}}
                <a href="{{ route('home') }}" class="hidden sm:flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition border border-white/20">
                    <i class="fas fa-home"></i> Beranda
                </a>

                <button @click="toggleDark()" class="p-2 rounded-full hover:bg-white/10 transition transform hover:rotate-12">
                    <i class="fas" :class="darkMode ? 'fa-sun text-yellow-300' : 'fa-moon'"></i>
                </button>

                <div class="flex items-center gap-3 bg-white/10 px-3 py-1 rounded-full border border-white/20">
                    <img src="{{ Auth::user()->foto ? asset('storage/'.Auth::user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0D8ABC&color=fff' }}" 
                         class="w-8 h-8 rounded-full border-2 border-white object-cover">
                    
                    <div class="hidden sm:block text-left">
                        <div class="text-sm font-bold leading-tight">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] uppercase opacity-80 leading-tight">{{ Auth::user()->role ?? 'User' }}</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs font-bold shadow-md transition hover:scale-105 flex items-center gap-1">
                        <i class="fas fa-sign-out-alt"></i> 
                        <span class="hidden md:inline">LOGOUT</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <aside class="fixed left-0 top-0 h-full bg-gray-800 dark:bg-gray-950 text-white w-64 transform transition-transform duration-300 z-40 pt-20 border-r border-gray-700"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        
        <div class="p-4">
            <div class="flex flex-col items-center mb-8 pb-6 border-b border-gray-700 animate-float">
                <div class="relative group cursor-pointer">
                    <img src="{{ Auth::user()->foto ? asset('storage/'.Auth::user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=3b82f6&color=fff' }}" 
                         alt="Profile" 
                         class="w-20 h-20 rounded-full mb-3 border-4 border-secondary shadow-lg shadow-blue-500/30 object-cover group-hover:scale-105 transition">
                    
                    <div class="absolute bottom-4 right-0 w-4 h-4 bg-green-500 rounded-full border-2 border-gray-800" title="Online"></div>
                </div>
                
                <h3 class="font-bold text-center text-lg px-2 break-words">{{ Auth::user()->name }}</h3>
                
                <p class="text-xs text-gray-400 bg-gray-700/50 px-3 py-1 rounded-full mt-1 border border-gray-600">
                    {{ Auth::user()->email }}
                </p>
            </div>

            <nav class="space-y-2">
                {{-- Tombol Beranda untuk Mobile (muncul di sidebar juga) --}}
                <a href="{{ route('home') }}" class="lg:hidden flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group hover:bg-gray-700 hover:pl-6 text-gray-300">
                    <i class="fas fa-home w-5 text-gray-400 group-hover:text-white"></i>
                    <span class="font-medium">Ke Beranda Utama</span>
                </a>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-secondary shadow-lg shadow-blue-600/40 text-white' : 'hover:bg-gray-700 hover:pl-6 text-gray-300' }}">
                    <i class="fas fa-tachometer-alt w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-blue-400 group-hover:text-white' }}"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('laporan.*') ? 'bg-secondary shadow-lg shadow-blue-600/40 text-white' : 'hover:bg-gray-700 hover:pl-6 text-gray-300' }}">
                    <i class="fas fa-file-alt w-5 {{ request()->routeIs('laporan.*') ? 'text-white' : 'text-blue-400 group-hover:text-white' }}"></i>
                    <span class="font-medium">Laporan Masuk</span>
                    @if(isset($laporanBaru) && $laporanBaru > 0)
                        <span class="ml-auto bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full animate-pulse">{{ $laporanBaru }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.bantuan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.bantuan') ? 'bg-secondary shadow-lg shadow-blue-600/40 text-white' : 'hover:bg-gray-700 hover:pl-6 text-gray-300' }}">
                    <i class="fas fa-box w-5 text-yellow-400 group-hover:text-white"></i>
                    <span class="font-medium">Data Bantuan</span>
                </a>

                <a href="{{ route('admin.penyaluran') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.penyaluran') ? 'bg-secondary shadow-lg shadow-blue-600/40 text-white' : 'hover:bg-gray-700 hover:pl-6 text-gray-300' }}">
                    <i class="fas fa-truck w-5 text-green-400 group-hover:text-white"></i>
                    <span class="font-medium">Penyaluran</span>
                </a>

                <a href="{{ route('admin.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.pengaturan') ? 'bg-secondary shadow-lg shadow-blue-600/40 text-white' : 'hover:bg-gray-700 hover:pl-6 text-gray-300' }}">
                    <i class="fas fa-cog w-5 text-gray-400 group-hover:text-white"></i>
                    <span class="font-medium">Pengaturan</span>
                </a>
            </nav>
        </div>
    </aside>

    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         x-transition.opacity
         class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden glass-card">
    </div>

    <main class="pt-20 p-6 min-h-screen transition-all duration-300"
          :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-0'">
        
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard Administrator</h1>
                    <p class="text-gray-500 dark:text-gray-400">Overview sistem periode {{ date('F Y') }}</p>
                </div>
                <div class="hidden md:block">
                     <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">
                        <i class="fas fa-clock mr-1"></i> Update: Realtime
                     </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary to-blue-600 p-6 text-white shadow-xl transform hover:-translate-y-2 hover:scale-105 transition duration-300 group">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-white/20 transition-all group-hover:scale-150"></div>
                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div class="flex items-center justify-between">
                            <div class="p-2 bg-white/20 rounded-lg"><i class="fas fa-folder-open text-xl"></i></div>
                            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded">+2.5%</span>
                        </div>
                        <div class="mt-4">
                            <h2 class="text-4xl font-bold animate-pulse-slow">{{ $totalLaporan ?? 156 }}</h2>
                            <p class="text-blue-100 text-sm font-medium tracking-wide">TOTAL LAPORAN</p>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-500 to-yellow-500 p-6 text-white shadow-xl transform hover:-translate-y-2 hover:scale-105 transition duration-300 group">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-white/20 transition-all group-hover:scale-150"></div>
                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div class="flex items-center justify-between">
                            <div class="p-2 bg-white/20 rounded-lg"><i class="fas fa-bell text-xl animate-bounce"></i></div>
                            <span class="text-xs font-bold bg-red-600/80 px-2 py-1 rounded">ACTION NEEDED</span>
                        </div>
                        <div class="mt-4">
                            <h2 class="text-4xl font-bold">{{ $laporanBaru ?? 12 }}</h2>
                            <p class="text-orange-100 text-sm font-medium tracking-wide">MENUNGGU VERIFIKASI</p>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-500 p-6 text-white shadow-xl transform hover:-translate-y-2 hover:scale-105 transition duration-300 group">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-white/20 transition-all group-hover:scale-150"></div>
                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div class="flex items-center justify-between">
                            <div class="p-2 bg-white/20 rounded-lg"><i class="fas fa-cog fa-spin text-xl"></i></div>
                        </div>
                        <div class="mt-4">
                            <h2 class="text-4xl font-bold">{{ $laporanProses ?? 34 }}</h2>
                            <p class="text-cyan-100 text-sm font-medium tracking-wide">SEDANG DIPROSES</p>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 p-6 text-white shadow-xl transform hover:-translate-y-2 hover:scale-105 transition duration-300 group">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-white/20 transition-all group-hover:scale-150"></div>
                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div class="flex items-center justify-between">
                            <div class="p-2 bg-white/20 rounded-lg"><i class="fas fa-check-circle text-xl"></i></div>
                            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded">Sukses</span>
                        </div>
                        <div class="mt-4">
                            <h2 class="text-4xl font-bold">{{ $laporanSelesai ?? 110 }}</h2>
                            <p class="text-green-100 text-sm font-medium tracking-wide">BERHASIL DISALURKAN</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-list text-secondary"></i> Laporan Terbaru
                    </h3>
                    <a href="{{ route('laporan.index') }}" class="text-sm text-secondary hover:text-primary dark:text-blue-400 hover:underline font-semibold">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 uppercase text-xs font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Pelapor</th>
                                <th class="px-6 py-4">Lokasi</th>
                                <th class="px-6 py-4">Jenis Bantuan</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($laporanTerbaru ?? [] as $item)
                            <tr class="hover:bg-blue-50 dark:hover:bg-gray-700/50 transition duration-150 group">
                                <td class="px-6 py-4">
                                    @if($item->status == 'Baru')
                                        <span class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200 dark:border-yellow-800 animate-pulse">
                                            {{ $item->status }}
                                        </span>
                                    @elseif($item->status == 'Diproses')
                                        <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-3 py-1 rounded-full text-xs font-bold border border-blue-200 dark:border-blue-800">
                                            {{ $item->status }}
                                        </span>
                                    @else
                                        <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-3 py-1 rounded-full text-xs font-bold border border-green-200 dark:border-green-800">
                                            {{ $item->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800 dark:text-gray-100">{{ $item->nama }}</div>
                                    <div class="text-xs text-gray-500">ID: #{{ $item->id }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    <i class="fas fa-map-marker-alt text-red-400 mr-1"></i> {{ Str::limit($item->lokasi, 25) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-sm font-medium text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-900/30 px-2 py-1 rounded">
                                        <i class="fas fa-box-open text-xs"></i> {{ $item->jenis }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-secondary hover:text-primary dark:text-blue-400 dark:hover:text-blue-300 transform hover:scale-110 transition">
                                        <i class="fas fa-eye text-lg"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                             <tr class="dark:bg-gray-800">
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-4xl mb-2 opacity-50"></i>
                                        <p>Belum ada data laporan terbaru.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>
</html>