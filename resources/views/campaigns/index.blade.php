@extends('layouts.app')

@section('title', 'Semua Campaign - SiBantu')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700 py-16 text-white text-center relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-400 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10 px-4">
            <span class="inline-block px-4 py-1 rounded-full bg-white/20 text-sm font-medium mb-4">🔥 Campaign Aktif</span>
            <h1 class="text-3xl md:text-5xl font-bold mb-4">Urgent Causes Need Your Help</h1>
            <p class="text-lg text-blue-100 max-w-2xl mx-auto mb-8">SiBantu menghubungkan Anda dengan kampanye bantuan
                bencana dan kemanusiaan yang terverifikasi.</p>
        </div>
    </div>

    <div id="campaigns" class="container mx-auto px-4 py-12">
        <!-- Filter/Sort Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 mb-8">
            <form method="GET" action="{{ route('campaigns.index') }}" class="flex flex-col lg:flex-row gap-4 justify-between">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Cari kampanye...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap gap-4">
                    <select name="category" class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 py-2.5 px-4">
                        <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>Semua Kategori</option>
                        <option value="bencana" {{ request('category') == 'bencana' ? 'selected' : '' }}>Bencana Alam</option>
                        <option value="kesehatan" {{ request('category') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                        <option value="pendidikan" {{ request('category') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                        <option value="sosial" {{ request('category') == 'sosial' ? 'selected' : '' }}>Sosial</option>
                        <option value="lainnya" {{ request('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>

                    <select name="sort" class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 py-2.5 px-4">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="target_asc" {{ request('sort') == 'target_asc' ? 'selected' : '' }}>Target Terkecil</option>
                        <option value="target_desc" {{ request('sort') == 'target_desc' ? 'selected' : '' }}>Target Terbesar</option>
                    </select>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-medium transition">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    
                    @if(request()->hasAny(['search', 'category', 'sort']))
                        <a href="{{ route('campaigns.index') }}" class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 px-4 py-2.5 rounded-xl font-medium transition flex items-center justify-center">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($campaigns as $campaign)
                <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 border border-gray-100 dark:border-gray-700 flex flex-col h-full">
                    <!-- Image -->
                    <div class="h-48 bg-gray-200 dark:bg-gray-700 relative overflow-hidden flex-shrink-0">
                        @if($campaign->image_url)
                            <img src="{{ asset('storage/' . $campaign->image_url) }}" alt="{{ $campaign->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @elseif($campaign->report && $campaign->report->image_url)
                            <img src="{{ asset('storage/' . $campaign->report->image_url) }}" alt="{{ $campaign->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">
                                <i class="fas fa-image text-3xl"></i>
                            </div>
                        @endif

                        <!-- Badge -->
                        <div class="absolute top-3 left-3 flex gap-2">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/90 dark:bg-gray-900/90 text-blue-600 backdrop-blur-sm shadow-sm">
                                {{ ucfirst($campaign->category ?? 'Umum') }}
                            </span>
                        </div>

                        <!-- Days Left -->
                        @php $daysLeft = now()->diffInDays($campaign->deadline, false); @endphp
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $daysLeft <= 7 ? 'bg-red-500' : 'bg-gray-900/80' }} text-white backdrop-blur-sm shadow-sm">
                                <i class="far fa-clock mr-1"></i> {{ $daysLeft >= 0 ? $daysLeft . ' hari' : 'Selesai' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-1">
                        <!-- Author -->
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-xs text-blue-600 font-bold">
                                {{ substr($campaign->fundraiser->name ?? 'A', 0, 1) }}
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[150px]">
                                {{ $campaign->fundraiser->name ?? 'Admin SiBantu' }}
                            </span>
                            @if($campaign->is_verified)
                                <i class="fas fa-check-circle text-blue-500 text-xs" title="Terverifikasi"></i>
                            @endif
                        </div>

                        <!-- Title -->
                        <h3 class="font-bold text-lg text-gray-800 dark:text-white mb-3 line-clamp-2">
                            <a href="{{ route('campaigns.show', $campaign->slug) }}" class="hover:text-blue-600 transition">
                                {{ $campaign->title }}
                            </a>
                        </h3>
                        
                        <!-- Progress -->
                        @php
                            $percent = $campaign->target_amount > 0 ? ($campaign->collected_amount / $campaign->target_amount) * 100 : 0;
                            $percent = min($percent, 100);
                        @endphp
                        <div class="mt-auto">
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                            </div>
                            <div class="flex justify-between items-center text-sm mb-4">
                                <span class="font-bold text-gray-800 dark:text-white">Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</span>
                                <span class="text-gray-500 text-xs">{{ number_format($percent, 0) }}%</span>
                            </div>

                            <a href="{{ route('campaigns.show', $campaign->slug) }}"
                                class="block w-full text-center bg-white dark:bg-gray-700 border border-blue-600 text-blue-600 dark:text-blue-400 py-2.5 rounded-xl font-semibold hover:bg-blue-50 dark:hover:bg-gray-600 transition">
                                Donasi Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($campaigns->count() === 0)
            <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700">
                <div class="w-16 h-16 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-search text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Tidak Ada Campaign Ditemukan</h3>
                <p class="text-gray-500 mb-6">Coba ubah kata kunci pencarian atau filter kategori Anda.</p>
                <a href="{{ route('campaigns.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">Reset Filter</a>
            </div>
        @endif

        <!-- Pagination -->
        <div class="mt-12">
            {{ $campaigns->links() }}
        </div>
    </div>
@endsection