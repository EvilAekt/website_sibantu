@extends('layouts.app')

@section('title', 'Beranda - SiBantu')

@section('content')

    <section
        class="relative bg-gradient-to-br from-primary-600 via-primary-700 to-blue-600 dark:from-gray-900 dark:via-primary-900 dark:to-gray-950 py-24 overflow-hidden">
        <div class="absolute inset-0 opacity-10 dark:opacity-20 pointer-events-none">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full blur-3xl mix-blend-overlay"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-400 rounded-full blur-3xl mix-blend-overlay"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-blue-50 text-xs font-semibold backdrop-blur-md mb-8">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                Platform Bantuan #1 Indonesia
            </div>

            <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
                Saling Bantu, <br>
                <span class="text-blue-200">Wujudkan Harapan.</span>
            </h1>

            <p class="text-lg text-blue-100 max-w-2xl mx-auto mb-10">
                Platform digital untuk pelaporan dan penyaluran bantuan sosial yang transparan, cepat, dan tepat sasaran
                bagi masyarakat Indonesia.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('campaigns.index') }}"
                    class="px-8 py-4 bg-white text-blue-600 rounded-full font-bold text-lg hover:shadow-2xl hover:scale-105 transition transform">
                    <i class="fas fa-heart mr-2"></i> Donasi Sekarang
                </a>
                <a href="{{ route('laporan.create') }}"
                    class="px-8 py-4 bg-transparent border-2 border-white/30 text-white rounded-full font-bold text-lg hover:bg-white/10 hover:shadow-2xl transition">
                    <i class="fas fa-bullhorn mr-2"></i> Laporkan
                </a>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-12 md:h-20 text-gray-50 dark:text-gray-950"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                    fill="currentColor"></path>
            </svg>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl text-center hover:-translate-y-1 transition duration-300">
                <div
                    class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-primary mb-4">
                    <i class="fas fa-file-alt text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">1,230+</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Laporan Masuk</p>
            </div>
            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl text-center hover:-translate-y-1 transition duration-300">
                <div
                    class="w-16 h-16 mx-auto bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center text-green-600 mb-4">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">980+</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Tersalurkan</p>
            </div>
            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl text-center hover:-translate-y-1 transition duration-300">
                <div
                    class="w-16 h-16 mx-auto bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center text-orange-600 mb-4">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">500+</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Relawan Aktif</p>
            </div>
        </div>
    </div>

    <!-- Featured Campaigns Section -->
    @if($campaigns->count() > 0)
        <section class="py-20 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span
                        class="inline-block px-4 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">Campaign
                        Pilihan</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Bantu Mereka yang Membutuhkan
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Setiap donasi berharga. Pilih campaign di
                        bawah ini dan jadilah bagian dari perubahan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($campaigns as $campaign)
                        <div
                            class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                            <!-- Image -->
                            <div
                                class="h-48 bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-gray-700 dark:to-gray-800 overflow-hidden relative">
                                @if($campaign->image_url)
                                    <img src="{{ asset('storage/' . $campaign->image_url) }}" alt="{{ $campaign->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @elseif($campaign->report && $campaign->report->image_url)
                                    <img src="{{ asset('storage/' . $campaign->report->image_url) }}" alt="{{ $campaign->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="flex items-center justify-center h-full">
                                        <svg class="w-16 h-16 text-blue-200 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-500 text-white shadow-lg">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Terverifikasi
                                    </span>
                                </div>
                                @php
                                    $daysLeft = now()->diffInDays($campaign->deadline, false);
                                @endphp
                                @if($daysLeft >= 0)
                                    <div class="absolute top-3 right-3">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $daysLeft <= 7 ? 'bg-red-500' : 'bg-gray-900/80' }} text-white backdrop-blur-sm">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $daysLeft }} hari lagi
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <!-- Title -->
                                <h3 class="font-bold text-lg text-gray-800 dark:text-white mb-3 line-clamp-2 min-h-[56px]">
                                    <a href="{{ route('campaigns.show', $campaign->slug) }}"
                                        class="hover:text-blue-600 transition">{{ $campaign->title }}</a>
                                </h3>

                                <!-- Progress Bar -->
                                @php
                                    $percent = $campaign->target_amount > 0 ? ($campaign->collected_amount / $campaign->target_amount) * 100 : 0;
                                    $percent = min($percent, 100);
                                @endphp
                                <div class="relative mb-4">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2.5 rounded-full transition-all duration-500"
                                            style="width: {{ $percent }}%"></div>
                                    </div>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-sm font-bold text-blue-600">{{ number_format($percent, 0) }}%</span>
                                        <span class="text-xs text-gray-500">dari target</span>
                                    </div>
                                </div>

                                <!-- Stats -->
                                <div class="flex justify-between items-end mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Terkumpul</p>
                                        <p class="font-bold text-lg text-gray-800 dark:text-white">Rp
                                            {{ number_format($campaign->collected_amount, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Target</p>
                                        <p class="font-semibold text-gray-600 dark:text-gray-300">Rp
                                            {{ number_format($campaign->target_amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <!-- Action -->
                                <a href="{{ route('campaigns.donate', $campaign->slug) }}"
                                    class="block w-full text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg hover:scale-[1.02] transition transform">
                                    Donasi Sekarang
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('campaigns.index') }}"
                        class="inline-flex items-center px-8 py-4 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white rounded-full font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        Lihat Semua Campaign
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <section class="py-20 bg-gray-50 dark:bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Mengapa SiBantu?</h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-12">Kami memastikan setiap bantuan yang Anda
                berikan atau laporkan tercatat dengan transparan.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:-translate-y-1 transition duration-300">
                    <div
                        class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-bolt text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Respon Cepat</h3>
                    <p class="text-sm text-gray-500">Tim admin memverifikasi laporan < 24 jam.</p>
                </div>
                <div
                    class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:-translate-y-1 transition duration-300">
                    <div
                        class="w-16 h-16 mx-auto bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Amanah</h3>
                    <p class="text-sm text-gray-500">Data transparan dan dapat dipertanggungjawabkan.</p>
                </div>
                <div
                    class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:-translate-y-1 transition duration-300">
                    <div
                        class="w-16 h-16 mx-auto bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-mobile-alt text-2xl text-orange-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Mudah Diakses</h3>
                    <p class="text-sm text-gray-500">Laporkan kejadian dari mana saja lewat HP.</p>
                </div>
            </div>
        </div>
    </section>
@endsection