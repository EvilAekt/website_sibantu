@extends('layouts.app')

@section('title', $campaign->title . ' - SiBantu')

@section('content')
    <div class="bg-gray-50 dark:bg-gray-900 py-8 min-h-screen">
        <div class="container mx-auto px-4">
            <!-- Breadcrumb -->
            <nav class="flex mb-6 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <span class="mx-2">/</span>
                <a href="{{ route('campaigns.index') }}" class="hover:text-blue-600">Campaigns</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 dark:text-white truncate max-w-xs">{{ $campaign->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Content -->
                <div class="lg:col-span-2">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden mb-6 border border-gray-100 dark:border-gray-700">
                        <!-- Featured Image -->
                        <div class="h-64 md:h-[400px] bg-gray-200 dark:bg-gray-700 overflow-hidden relative group">
                            @if($campaign->report && $campaign->report->image_url)
                                <img src="{{ asset('storage/' . $campaign->report->image_url) }}" alt="{{ $campaign->title }}"
                                    class="w-full h-full object-cover">
                            @elseif($campaign->image_url)
                                <img src="{{ asset('storage/' . $campaign->image_url) }}" alt="{{ $campaign->title }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <i class="fas fa-image text-5xl"></i>
                                </div>
                            @endif

                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold bg-white/90 dark:bg-gray-900/90 text-blue-600 backdrop-blur-sm shadow-sm">
                                    {{ ucfirst($campaign->category ?? 'Umum') }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 md:p-8">
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white mb-4">
                                {{ $campaign->title }}</h1>

                            <div
                                class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-6 pb-6 border-b border-gray-100 dark:border-gray-700">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 font-bold text-xs">
                                        {{ substr($campaign->fundraiser->name ?? 'A', 0, 1) }}
                                    </div>
                                    <span>{{ $campaign->fundraiser->name ?? 'Admin' }}</span>
                                    @if($campaign->is_verified)
                                        <i class="fas fa-check-circle text-blue-500" title="Terverifikasi"></i>
                                    @endif
                                </div>
                                <span class="hidden md:inline">•</span>
                                <span class="flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                                    {{ $campaign->report->location ?? 'Indonesia' }}
                                </span>
                                <span class="hidden md:inline">•</span>
                                <span>{{ $campaign->created_at->format('d M Y') }}</span>
                            </div>

                            <!-- Tabs -->
                            <div x-data="{ tab: 'story' }">
                                <div
                                    class="flex space-x-6 border-b border-gray-100 dark:border-gray-700 mb-6 overflow-x-auto">
                                    <button @click="tab = 'story'"
                                        :class="{ 'border-blue-600 text-blue-600': tab === 'story', 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200': tab !== 'story' }"
                                        class="pb-3 text-sm font-semibold border-b-2 transition focus:outline-none whitespace-nowrap">
                                        Cerita
                                    </button>
                                    <button @click="tab = 'updates'"
                                        :class="{ 'border-blue-600 text-blue-600': tab === 'updates', 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200': tab !== 'updates' }"
                                        class="pb-3 text-sm font-semibold border-b-2 transition focus:outline-none whitespace-nowrap">
                                        Kabar Terbaru ({{ $campaign->updates->count() }})
                                    </button>
                                    <button @click="tab = 'donors'"
                                        :class="{ 'border-blue-600 text-blue-600': tab === 'donors', 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200': tab !== 'donors' }"
                                        class="pb-3 text-sm font-semibold border-b-2 transition focus:outline-none whitespace-nowrap">
                                        Donatur ({{ $donors->count() }})
                                    </button>
                                </div>

                                <!-- Story Tab -->
                                <div x-show="tab === 'story'" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0">
                                    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                                        <p class="whitespace-pre-line leading-relaxed">{{ $campaign->description }}</p>
                                    </div>
                                </div>

                                <!-- Updates Tab -->
                                <div x-show="tab === 'updates'" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                                    @if($campaign->updates->isEmpty())
                                        <div
                                            class="text-center py-12 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-dashed border-gray-200 dark:border-gray-600">
                                            <i class="far fa-newspaper text-3xl text-gray-400 mb-3"></i>
                                            <p class="text-gray-500 dark:text-gray-400">Belum ada kabar terbaru dari penggalang
                                                dana.</p>
                                        </div>
                                    @else
                                        <div
                                            class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-300 before:to-transparent">
                                            @foreach($campaign->updates as $update)
                                                <div
                                                    class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                                    <div
                                                        class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:border-gray-800 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                                        <i class="fas fa-bullhorn text-sm"></i>
                                                    </div>
                                                    <div
                                                        class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
                                                        <div class="flex items-center justify-between space-x-2 mb-1">
                                                            <div class="font-bold text-gray-900 dark:text-white">
                                                                {{ $update->title }}</div>
                                                            <time
                                                                class="font-caveat font-medium text-blue-600 text-xs">{{ $update->created_at->format('d M Y') }}</time>
                                                        </div>
                                                        <div class="text-gray-600 dark:text-gray-400 text-sm whitespace-pre-line">
                                                            {{ $update->content }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <!-- Donors Tab -->
                                <div x-show="tab === 'donors'" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                                    @if($donors->isEmpty())
                                        <div
                                            class="text-center py-12 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-dashed border-gray-200 dark:border-gray-600">
                                            <i class="fas fa-hand-holding-heart text-3xl text-gray-400 mb-3"></i>
                                            <p class="text-gray-500 dark:text-gray-400">Jadilah donatur pertama!</p>
                                        </div>
                                    @else
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($donors as $donor)
                                                <div
                                                    class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-100 dark:border-gray-700">
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold mr-3 shadow-md">
                                                        {{ substr(strtoupper($donor->user->name ?? 'Anonim'), 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                                            {{ $donor->user->name ?? 'Orang Baik' }}</p>
                                                        <p class="text-xs text-blue-600 font-medium my-0.5">Rp
                                                            {{ number_format($donor->amount, 0, ',', '.') }}</p>
                                                        <p class="text-[10px] text-gray-400">
                                                            {{ $donor->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Share -->
                            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 font-medium">Bagikan campaign ini:
                                </p>
                                <div class="flex gap-2">
                                    <a href="https://wa.me/?text={{ urlencode($campaign->title . ' - Bantu sekarang di ' . url()->current()) }}"
                                        target="_blank"
                                        class="flex-1 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium text-center transition">
                                        <i class="fab fa-whatsapp mr-1"></i> WhatsApp
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                        target="_blank"
                                        class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium text-center transition">
                                        <i class="fab fa-facebook-f mr-1"></i> Facebook
                                    </a>
                                    <button
                                        onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('Link disalin!')"
                                        class="flex-1 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600 rounded-lg text-sm font-medium text-center transition">
                                        <i class="fas fa-link mr-1"></i> Salin Link
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Donation Card -->
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 sticky top-24 border border-blue-100 dark:border-blue-900/30">
                        @php
                            $percent = $campaign->target_amount > 0 ? ($campaign->collected_amount / $campaign->target_amount) * 100 : 0;
                            $daysLeft = now()->diffInDays($campaign->deadline, false);
                        @endphp

                        <div class="mb-6">
                            <div class="flex items-end gap-1 mb-1">
                                <p class="text-3xl font-bold text-gray-900 dark:text-white">Rp
                                    {{ number_format($campaign->collected_amount, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">terkumpul dari target <span
                                    class="font-medium text-gray-700 dark:text-gray-300">Rp
                                    {{ number_format($campaign->target_amount, 0, ',', '.') }}</span></p>
                        </div>

                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 mb-6">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full relative transition-all duration-1000"
                                style="width: {{ min($percent, 100) }}%">
                                <span
                                    class="absolute right-0 -top-7 text-xs font-bold text-white bg-blue-600 px-2 py-0.5 rounded shadow-sm after:content-[''] after:absolute after:top-full after:left-1/2 after:-translate-x-1/2 after:border-4 after:border-t-blue-600 after:border-transparent">{{ number_format($percent, 0) }}%</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Donatur</p>
                                <p class="font-bold text-lg text-gray-800 dark:text-white">{{ $donors->count() }}</p>
                            </div>
                            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Sisa Waktu</p>
                                <p
                                    class="font-bold text-lg {{ $daysLeft <= 7 ? 'text-red-500' : 'text-gray-800 dark:text-white' }}">
                                    {{ $daysLeft >= 0 ? $daysLeft . ' Hari' : 'Selesai' }}
                                </p>
                            </div>
                        </div>

                        @if($daysLeft >= 0)
                            <a href="{{ route('campaigns.donate', $campaign->slug) }}"
                                class="block w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-center py-4 rounded-xl font-bold text-lg hover:shadow-lg hover:scale-[1.02] transition transform mb-4 shadow-blue-500/30">
                                Donasi Sekarang <i class="fas fa-heart ml-2 animate-pulse"></i>
                            </a>
                        @else
                            <button disabled
                                class="block w-full bg-gray-300 dark:bg-gray-700 text-gray-500 cursor-not-allowed text-center py-4 rounded-xl font-bold text-lg mb-4">
                                Campaign Selesai
                            </button>
                        @endif

                        <div class="flex items-center justify-center space-x-2 text-gray-500 dark:text-gray-400 text-xs">
                            <i class="fas fa-shield-alt text-green-500"></i>
                            <span>Donasi aman & terverifikasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection