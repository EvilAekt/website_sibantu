<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Bantuan | SiBantu</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a8a',
                        secondary: '#3b82f6',
                        dark: '#0f172a',
                        darker: '#020617',
                        card: '#1e293b'
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>

<style>
    /* 1. BASE STYLES (Tampilan Default / Light Mode - Putih Bersih) */
    .glass-panel {
        background: rgba(255, 255, 255, 0.95); /* Putih solid tapi agak transparan */
        backdrop-filter: blur(12px);
        border: 1px solid #e5e7eb; /* Border abu tipis */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); /* Bayangan halus */
        transition: all 0.3s ease; /* Animasi halus saat ganti mode */
    }

    .glass-input {
        background: #f9fafb; /* Background input abu terang */
        border: 1px solid #d1d5db;
        color: #1f2937; /* Teks hitam/abu tua */
        transition: all 0.3s ease;
    }

    .glass-input:focus {
        background: #ffffff;
        border-color: #3b82f6; /* Biru primary */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        outline: none;
    }

    .glass-input::placeholder {
        color: #9ca3af;
    }

    /* 2. DARK MODE OVERRIDES (Efek 'Glass' Keren HANYA saat Dark Mode) */
    /* Kode ini jalan otomatis saat class 'dark' ada di tag <html> */
    
    .dark .glass-panel {
        background: rgba(30, 41, 59, 0.7); /* Kembali ke Transparan Gelap */
        border-color: rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5); /* Shadow lebih dramatis */
    }

    .dark .glass-input {
        background: rgba(15, 23, 42, 0.6); /* Input jadi gelap transparan */
        border-color: rgba(59, 130, 246, 0.3);
        color: white; /* Teks jadi putih */
    }

    .dark .glass-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 15px rgba(59, 130, 246, 0.3); /* Glow effect biru */
    }

    .dark .glass-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    [x-cloak] { display: none !important; }
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-950 text-gray-800 dark:text-gray-100 transition-colors duration-300 min-h-screen font-sans"
      x-data="{ 
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
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

    <nav class="fixed top-0 w-full z-50 transition-all duration-300 bg-gradient-to-r from-primary to-blue-600 dark:from-darker dark:to-gray-900 shadow-lg border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="bg-white/10 p-2 rounded-full backdrop-blur-sm">
                        <i class="fas fa-hand-holding-heart text-white text-lg"></i>
                    </div>
                    <span class="font-bold text-xl text-white tracking-wide">SiBantu</span>
                </div>

                <div class="hidden md:flex items-center gap-6">
                    <a href="#" class="text-gray-300 hover:text-white transition font-medium text-sm">Beranda</a>
                    <a href="#" class="text-white font-bold border-b-2 border-blue-400 pb-1 text-sm">Daftar Bantuan</a>
                    <a href="#" class="text-gray-300 hover:text-white transition font-medium text-sm">Laporkan</a>
                    
                    <button @click="toggleDark()" class="p-2 rounded-full bg-white/10 hover:bg-white/20 text-white transition transform hover:rotate-12 ml-4">
                        <i class="fas" :class="darkMode ? 'fa-sun text-yellow-400' : 'fa-moon'"></i>
                    </button>

                    @auth
                        <a href="/dashboard" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-lg shadow-blue-500/30 transition hover:-translate-y-0.5">
                            Dashboard
                        </a>
                    @else
                        <a href="/login" class="bg-white text-blue-900 hover:bg-gray-100 px-4 py-2 rounded-lg text-sm font-bold shadow transition">
                            Login
                        </a>
                    @endauth
                </div>

                <button class="md:hidden text-white text-xl">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <main class="pt-24 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold bg-clip-text  bg-gradient-to-r from-blue-600  mb-2 animate-float inline-block">
                Daftar Laporan Bantuan
            </h1>
            <p class="text-gray-600 dark:text-gray-400">Pantau dan kelola laporan bantuan masyarakat secara transparan.</p>
        </div>

        <div class="glass-panel rounded-2xl p-6 mb-10 shadow-2xl">
            <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                <div class="md:col-span-4 lg:col-span-1 relative">
                    <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                    <input type="text" placeholder="Cari nama atau lokasi..." 
                           class="w-full pl-10 pr-4 py-3 rounded-xl glass-input placeholder-gray-500 focus:ring-2 focus:ring-blue-500 transition-all">
                </div>

                <div class="relative">
                    <i class="fas fa-box absolute left-3 top-3.5 text-gray-400"></i>
                    <select class="w-full pl-10 pr-4 py-3 rounded-xl glass-input appearance-none cursor-pointer">
                        <option value="">Semua Jenis</option>
                        <option value="sembako">Sembako</option>
                        <option value="uang">Uang Tunai</option>
                        <option value="medis">Medis</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-3.5 text-gray-400 text-xs pointer-events-none"></i>
                </div>

                <div class="relative">
                    <i class="fas fa-filter absolute left-3 top-3.5 text-gray-400"></i>
                    <select class="w-full pl-10 pr-4 py-3 rounded-xl glass-input appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="baru">Baru</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-3.5 text-gray-400 text-xs pointer-events-none"></i>
                </div>

                <div class="flex gap-2">
                    <input type="date" class="w-full px-4 py-3 rounded-xl glass-input">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-lg shadow-blue-600/30 transition hover:scale-105">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($laporan as $item)
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100 transform hover:-translate-y-1 group">
        <div class="relative h-48 bg-gray-200 overflow-hidden">
            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors z-10"></div>
            <img src="{{ asset('storage/' . $item->foto) }}" 
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($item->nama_pelapor) }}&background=1e3a8a&color=fff&size=400';">
            
            @php
                $statusColor = match($item->status) {
                    'baru' => 'bg-blue-500',
                    'diproses' => 'bg-yellow-500',
                    'selesai' => 'bg-green-500',
                    default => 'bg-gray-500'
                };
            @endphp
            <div class="absolute top-3 right-3 z-20">
                <span class="{{ $statusColor }} text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg uppercase tracking-wide">
                    {{ $item->status }}
                </span>
            </div>
        </div>

        <div class="p-5">
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs font-semibold text-gray-500 flex items-center gap-1">
                    <i class="far fa-calendar-alt"></i> {{ $item->created_at->format('d M Y') }}
                </span>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded">
                    {{ ucfirst($item->jenis_bantuan ?? 'Umum') }}
                </span>
            </div>

            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-1 group-hover:text-blue-600 transition-colors">
                {{ $item->nama_pelapor }}
            </h3>

            <p class="text-sm text-gray-500 mb-4 flex items-start gap-2">
                <i class="fas fa-map-marker-alt text-red-500 mt-1"></i>
                <span class="line-clamp-1">{{ $item->lokasi }}</span>
            </p>

            <a href="{{ route('laporan.show', $item->id) }}" class="block w-full text-center bg-gray-50 hover:bg-blue-600 hover:text-white text-gray-700 font-semibold py-2 rounded-lg transition-colors duration-200 border border-gray-200 hover:border-blue-600">
                Lihat Detail
            </a>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <div class="bg-gray-50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-search text-3xl text-gray-300"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-600">Data Tidak Ditemukan</h3>
        <p class="text-gray-400">Coba ubah filter pencarian kamu.</p>
    </div>
    @endforelse
</div>
        
        <div class="mt-8">
            </div>

    </main>


</body>
</html>