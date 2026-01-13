@extends('layouts.app')

@section('title', 'Laporan Bencana - SiBantu')

@section('content')
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-12">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Laporan Bencana</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Pantau dan laporkan kejadian bencana di sekitar Anda</p>
                </div>
                <a href="{{ route('laporan.create') }}" 
                   class="mt-4 md:mt-0 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-bold flex items-center shadow-lg transition transform hover:-translate-y-1">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Laporkan Bencana
                </a>
            </div>

            <!-- Filter Bar -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 mb-8">
                <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-col lg:flex-row gap-4 justify-between">
                    <!-- Search -->
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-red-500 focus:border-red-500"
                                placeholder="Cari lokasi atau judul laporan...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="flex flex-wrap gap-4">
                        <select name="category" class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-red-500 focus:border-red-500 py-2.5 px-4">
                            <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>Semua Kategori</option>
                            <option value="bencana" {{ request('category') == 'bencana' ? 'selected' : '' }}>Bencana Alam</option>
                            <option value="kesehatan" {{ request('category') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                            <option value="infrastruktur" {{ request('category') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                            <option value="sosial" {{ request('category') == 'sosial' ? 'selected' : '' }}>Sosial</option>
                        </select>

                        <select name="severity" class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-red-500 focus:border-red-500 py-2.5 px-4">
                            <option value="all" {{ request('severity') == 'all' ? 'selected' : '' }}>Semua Tingkat</option>
                            <option value="ringan" {{ request('severity') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                            <option value="sedang" {{ request('severity') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="berat" {{ request('severity') == 'berat' ? 'selected' : '' }}>Berat</option>
                            <option value="darurat" {{ request('severity') == 'darurat' ? 'selected' : '' }}>Darurat</option>
                        </select>

                        <select name="status" class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-red-500 focus:border-red-500 py-2.5 px-4">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>

                        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-2.5 rounded-xl font-medium transition">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($laporans as $laporan)
                    <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 border border-gray-100 dark:border-gray-700 h-full flex flex-col">
                        <div class="h-48 bg-gray-200 dark:bg-gray-700 relative overflow-hidden flex-shrink-0">
                            @if($laporan->image_url)
                                <img src="{{ asset('storage/' . $laporan->image_url) }}" alt="{{ $laporan->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <i class="fas fa-camera text-3xl"></i>
                                </div>
                            @endif

                            <!-- Severity Badge -->
                            <div class="absolute top-3 right-3">
                                @php
                                    $severityColor = match($laporan->severity ?? 'sedang') {
                                        'ringan' => 'bg-green-500',
                                        'sedang' => 'bg-yellow-500',
                                        'berat' => 'bg-orange-500',
                                        'darurat' => 'bg-red-600 animate-pulse',
                                        default => 'bg-gray-500'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm {{ $severityColor }}">
                                    {{ ucfirst($laporan->severity ?? 'Sedang') }}
                                </span>
                            </div>

                            <!-- Status Badge -->
                            <div class="absolute top-3 left-3">
                                @if($laporan->status == 'verified')
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-lg text-xs font-bold flex items-center shadow-sm">
                                        <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                    </span>
                                @elseif($laporan->status == 'pending')
                                    <span class="bg-yellow-500 text-white px-2 py-1 rounded-lg text-xs font-bold flex items-center shadow-sm">
                                        <i class="fas fa-clock mr-1"></i> Menunggu
                                    </span>
                                @else
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-lg text-xs font-bold flex items-center shadow-sm">
                                        <i class="fas fa-times-circle mr-1"></i> Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-3">
                                <i class="fas fa-calendar-alt mr-1"></i> {{ $laporan->created_at->format('d M Y, H:i') }}
                                <span class="mx-2">•</span>
                                <span class="text-blue-600 dark:text-blue-400 font-medium">{{ ucfirst($laporan->category ?? 'Umum') }}</span>
                            </div>

                            <h3 class="font-bold text-lg text-gray-800 dark:text-white mb-2 line-clamp-2">
                                <a href="{{ route('laporan.show', $laporan->id) }}" class="hover:text-red-600 transition">
                                    {{ $laporan->title }}
                                </a>
                            </h3>

                            <div class="flex items-start text-sm text-gray-600 dark:text-gray-300 mb-4">
                                <i class="fas fa-map-marker-alt text-red-500 mt-1 mr-2 flex-shrink-0"></i>
                                <span class="line-clamp-2">{{ $laporan->location }}</span>
                            </div>

                            <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs font-bold text-gray-600 dark:text-gray-300">
                                        {{ substr($laporan->user->name ?? 'A', 0, 1) }}
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[100px]">
                                        {{ $laporan->user->name ?? 'Anonim' }}
                                    </span>
                                </div>
                                <a href="{{ route('laporan.show', $laporan->id) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">
                                    Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700">
                        <div class="w-16 h-16 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-search text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Tidak Ada Laporan Ditemukan</h3>
                        <p class="text-gray-500 mb-6">Coba ubah filter pencarian Anda.</p>
                        <a href="{{ route('laporan.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">Reset Filter</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $laporans->links() }}
            </div>
        </div>
    </div>
@endsection