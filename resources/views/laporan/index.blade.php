@extends('layouts.app')

@section('title', 'Daftar Bantuan - SiBantu')

@section('content')

{{-- 1. STYLE ANIMASI & CSS KHUSUS HALAMAN INI --}}
<style>
    /* Animasi Fade In Up */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    /* Animasi Shimmer (Kilau) pada Tombol */
    @keyframes shimmer {
        100% { transform: translateX(100%); }
    }
    /* Class Animasi */
    .animate-fade-in {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    /* Hover Lift Effect */
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.1);
    }
    
    /* INPUT GLASS & DARK MODE FIX */
    .glass-input {
        background: #f9fafb;
        border: 1px solid #d1d5db;
        color: #1f2937;
        transition: all 0.3s ease;
    }
    .dark .glass-input {
        background: rgba(15, 23, 42, 0.6) !important;
        border-color: rgba(59, 130, 246, 0.3);
        color: #f3f4f6 !important;
    }
    .dark .glass-input::placeholder {
        color: #9ca3af;
    }
    .glass-input:focus {
        background: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
    }
</style>

{{-- Wrapper Utama --}}
<div class="max-w-7xl mx-auto">

    {{-- 2. HEADER SECTION (Judul Kiri, Tombol Kanan Bawah) --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-10 mt-8 gap-6 animate-fade-in">
        
        {{-- KIRI: Judul & Deskripsi --}}
        <div class="text-center md:text-left w-full md:w-auto">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-700 to-blue-500 dark:from-blue-400 dark:to-blue-200 mb-2">
                Daftar Laporan Bantuan
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed max-w-xl">
                Pantau data laporan yang masuk secara real-time. Gunakan filter di bawah untuk mencari data spesifik.
            </p>
        </div>

        {{-- KANAN: Tombol Export CSV (Posisi Turun Sedikit) --}}
        @auth
        <div class="w-full md:w-auto flex justify-center md:justify-end md:translate-y-2">
            <a href="{{ route('laporan.exportCSV') }}" class="group relative inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl shadow-md transition-all duration-300 hover:-translate-y-1 hover:shadow-emerald-500/30 overflow-hidden">
                {{-- Efek Kilau --}}
                <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                
                <i class="fas fa-file-csv text-lg"></i> 
                <span class="font-semibold text-sm tracking-wide">Download CSV</span>
            </a>
        </div>
        @endauth
    </div>

    {{-- 3. FILTER SECTION (Dark Mode Aman) --}}
    <div class="glass-panel rounded-xl p-5 mb-8 shadow-sm animate-fade-in" style="animation-delay: 0.1s;">
        <form action="{{ route('laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4">
            
            {{-- Search (4 kolom) --}}
            <div class="lg:col-span-4 relative">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400 dark:text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pelapor atau lokasi..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-lg glass-input focus:ring-2 focus:ring-blue-500 transition-all text-sm text-gray-800 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400">
            </div>
            
            {{-- Jenis (2 kolom) --}}
            <div class="lg:col-span-2 relative">
                <select name="jenis" class="w-full pl-3 pr-8 py-2.5 rounded-lg glass-input text-sm appearance-none cursor-pointer dark:text-white dark:bg-gray-800/50">
                    <option value="" class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Semua Jenis</option>
                    <option value="pangan" {{ request('jenis') == 'pangan' ? 'selected' : '' }} class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Pangan (Sembako)</option>
        
        <option value="sandang" {{ request('jenis') == 'sandang' ? 'selected' : '' }} class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Sandang</option>
        <option value="papan" {{ request('jenis') == 'papan' ? 'selected' : '' }} class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Papan</option>
                    <option value="Kesehatan" {{ request('jenis') == 'Kesehatan' ? 'selected' : '' }} class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Kesehatan</option>
                    <option value="Pendidikan" {{ request('jenis') == 'Pendidikan' ? 'selected' : '' }} class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Pendidikan</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 dark:text-gray-300 text-xs pointer-events-none"></i>
            </div>

            {{-- Status (2 kolom) --}}
            <div class="lg:col-span-2 relative">
                <select name="status" class="w-full pl-3 pr-8 py-2.5 rounded-lg glass-input text-sm appearance-none cursor-pointer dark:text-white dark:bg-gray-800/50">
                    <option value="" class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Semua Status</option>
                    <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }} class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Baru</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }} class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }} class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Selesai</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 dark:text-gray-300 text-xs pointer-events-none"></i>
            </div>

            {{-- Tanggal (2 kolom) --}}
            <div class="lg:col-span-2 relative">
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                       class="w-full px-3 py-2.5 rounded-lg glass-input text-sm cursor-pointer dark:text-white dark:[color-scheme:dark]">
            </div>

            {{-- Tombol Filter (2 kolom) --}}
            <div class="lg:col-span-2">
                <button type="submit" class="w-full h-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg shadow-sm transition text-sm font-semibold flex items-center justify-center gap-2 transform active:scale-95">
                    <i class="fas fa-filter"></i> Terapkan
                </button>
            </div>
        </form>
    </div>

    {{-- 4. CARD GRID (Animasi Staggered) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($laporan as $index => $item)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 group hover-lift animate-fade-in"
             style="animation-delay: {{ ($index * 0.1) + 0.2 }}s;">
            
            {{-- Foto --}}
            <div class="relative h-48 bg-gray-200 dark:bg-gray-700 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60 group-hover:opacity-40 transition-opacity z-10"></div>
                <img src="{{ asset('storage/' . $item->foto) }}" 
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($item->nama_pelapor) }}&background=1e3a8a&color=fff&size=400';">
                
                @php
                    $statusColor = match(strtolower($item->status)) {
                        'baru' => 'bg-blue-600',
                        'diproses' => 'bg-yellow-500',
                        'selesai' => 'bg-green-500',
                        default => 'bg-gray-500'
                    };
                @endphp
                <div class="absolute top-3 right-3 z-20">
                    <span class="{{ $statusColor }} text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-lg uppercase tracking-wider backdrop-blur-sm bg-opacity-90">
                        {{ $item->status }}
                    </span>
                </div>
            </div>

            {{-- Konten Card --}}
            <div class="p-5">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 bg-gray-100 dark:bg-gray-700/50 px-2 py-1 rounded-full">
                        <i class="far fa-clock text-blue-500"></i> {{ $item->created_at->diffForHumans() }}
                    </span>
                    <span class="text-xs font-bold text-blue-700 dark:text-blue-300">
                        {{ ucfirst($item->jenis_bantuan ?? 'Umum') }}
                    </span>
                </div>

                <h3 class="text-base font-bold text-gray-800 dark:text-gray-100 mb-2 line-clamp-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" title="{{ $item->nama_pelapor }}">
                    {{ $item->nama_pelapor }}
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex items-start gap-2 h-10 overflow-hidden">
                    <i class="fas fa-map-marker-alt text-red-500 mt-1 flex-shrink-0 animate-bounce"></i>
                    <span class="line-clamp-2 leading-tight">{{ $item->lokasi }}</span>
                </p>

                <a href="{{ route('laporan.show', $item->id) }}" class="block w-full text-center bg-white dark:bg-gray-700/50 hover:bg-blue-600 text-blue-600 hover:text-white font-semibold py-2 rounded-lg text-sm transition-all border border-blue-200 dark:border-blue-900 hover:border-blue-600 shadow-sm hover:shadow-md">
                    Lihat Detail
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full flex flex-col items-center justify-center py-16 bg-white/50 dark:bg-gray-800/50 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700 animate-fade-in">
            <div class="bg-blue-50 dark:bg-gray-700 rounded-full w-20 h-20 flex items-center justify-center mb-4 shadow-inner">
                <i class="fas fa-search text-3xl text-blue-400"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200">Data Tidak Ditemukan</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Coba ubah kata kunci atau filter pencarian kamu.</p>
            <a href="{{ route('laporan.index') }}" class="mt-4 text-blue-600 hover:underline text-sm font-semibold">Reset Filter</a>
        </div>
        @endforelse
    </div>

    {{-- 5. FOOTER: Pagination Only --}}
    <div class="mt-12 flex justify-center pb-8 animate-fade-in" style="animation-delay: 0.5s;">
         {{ $laporan->links() }}
    </div>

</div>

@endsection