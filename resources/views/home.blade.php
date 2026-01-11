@extends('layouts.app')

@section('title', 'Beranda - SiBantu')

@section('content')

<section class="relative bg-gradient-to-br from-primary-600 via-primary-700 to-blue-600 dark:from-gray-900 dark:via-primary-900 dark:to-gray-950 py-24 overflow-hidden">
    <div class="absolute inset-0 opacity-10 dark:opacity-20 pointer-events-none">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full blur-3xl mix-blend-overlay"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-400 rounded-full blur-3xl mix-blend-overlay"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-blue-50 text-xs font-semibold backdrop-blur-md mb-8">
            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
            Platform Bantuan #1 Indonesia
        </div>

        <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
            Saling Bantu, <br> 
            <span class="text-blue-200">Wujudkan Harapan.</span>
        </h1>

        <p class="text-lg text-blue-100 max-w-2xl mx-auto mb-10">
            Platform digital untuk pelaporan dan penyaluran bantuan sosial yang transparan, cepat, dan tepat sasaran bagi masyarakat Indonesia.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('laporan.create') }}" class="px-8 py-4 bg-transparent border-2 border-white/30 text-white rounded-full font-bold text-lg hover:shadow-2xl hover:scale-105 transition transform">
                <i class="fas fa-bullhorn mr-2"></i> Laporkan Sekarang
            </a>
            <a href="{{ route('laporan.index') }}" class="px-8 py-4 bg-transparent border-2 border-white/30 text-white rounded-full font-bold text-lg hover:shadow-2xl hover:scale-105 transition transform">
                <i class="fas fa-search mr-2"></i> Lihat Data
            </a>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
        <svg class="relative block w-full h-12 md:h-20 text-gray-50 dark:text-gray-950" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor"></path>
        </svg>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl text-center hover:-translate-y-1 transition duration-300">
            <div class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-primary mb-4">
                <i class="fas fa-file-alt text-2xl"></i>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">1,230+</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Laporan Masuk</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl text-center hover:-translate-y-1 transition duration-300">
            <div class="w-16 h-16 mx-auto bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center text-green-600 mb-4">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">980+</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Tersalurkan</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl text-center hover:-translate-y-1 transition duration-300">
            <div class="w-16 h-16 mx-auto bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center text-orange-600 mb-4">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">500+</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Relawan Aktif</p>
        </div>
    </div>
</div>

<section class="py-20 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Mengapa SiBantu?</h2>
        <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-12">Kami memastikan setiap bantuan yang Anda berikan atau laporkan tercatat dengan transparan.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-6">
                <i class="fas fa-bolt text-4xl text-primary mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Respon Cepat</h3>
                <p class="text-sm text-gray-500">Tim admin memverifikasi laporan < 24 jam.</p>
            </div>
            <div class="p-6">
                <i class="fas fa-shield-alt text-4xl text-primary mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Amanah</h3>
                <p class="text-sm text-gray-500">Data transparan dan dapat dipertanggungjawabkan.</p>
            </div>
            <div class="p-6">
                <i class="fas fa-mobile-alt text-4xl text-primary mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Mudah Diakses</h3>
                <p class="text-sm text-gray-500">Laporkan kejadian dari mana saja lewat HP.</p>
            </div>
        </div>
    </div>
</section>
@endsection