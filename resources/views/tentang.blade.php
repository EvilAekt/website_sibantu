@extends('layouts.app')

@section('title', 'Tentang Kami - SiBantu')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-600 via-primary-700 to-blue-600 dark:from-gray-900 dark:via-primary-900 dark:to-gray-950 py-24 overflow-hidden">
    
    <!-- Animated Background -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-20 left-1/2 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-medium mb-6">
            <i class="fas fa-info-circle"></i>
            Tentang Platform Kami
        </div>
        
        <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
            Membangun Jembatan <br>
            <span class="bg-gradient-to-r from-blue-200 to-cyan-200 bg-clip-text text-transparent">
                Kebaikan Bersama
            </span>
        </h1>
        
        <p class="text-xl text-blue-100 max-w-3xl mx-auto leading-relaxed font-light">
            SiBantu hadir sebagai solusi modern dalam menghubungkan masyarakat yang membutuhkan 
            bantuan dengan sumber daya yang tersedia
        </p>
    </div>
</section>

<!-- Visi Misi Cards -->
<div class="max-w-7xl mx-auto px-4 -mt-1 relative z-20 mb-20">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Visi -->
        <div class="group glass-card p-10 rounded-3xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300">
            <div class="flex items-start gap-6">
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-transform">
                        <i class="fas fa-eye text-3xl text-white"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Visi Kami</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        Menjadi platform terpercaya dalam menghubungkan masyarakat yang membutuhkan
                        bantuan dengan sumber daya yang tersedia, serta menciptakan ekosistem kepedulian
                        sosial yang berkelanjutan di seluruh Indonesia.
                    </p>
                </div>
            </div>
        </div>

        <!-- Misi -->
        <div class="group glass-card p-10 rounded-3xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300">
            <div class="flex items-start gap-6">
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-transform">
                        <i class="fas fa-bullseye text-3xl text-white"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Misi Kami</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-gray-600 dark:text-gray-300">
                            <i class="fas fa-check-circle text-green-500 mt-1 flex-shrink-0"></i>
                            <span>Mempermudah proses pelaporan dan penyaluran bantuan</span>
                        </li>
                        <li class="flex items-start gap-3 text-gray-600 dark:text-gray-300">
                            <i class="fas fa-check-circle text-green-500 mt-1 flex-shrink-0"></i>
                            <span>Memastikan bantuan tepat sasaran dan terverifikasi</span>
                        </li>
                        <li class="flex items-start gap-3 text-gray-600 dark:text-gray-300">
                            <i class="fas fa-check-circle text-green-500 mt-1 flex-shrink-0"></i>
                            <span>Membangun jaringan relawan peduli sosial</span>
                        </li>
                        <li class="flex items-start gap-3 text-gray-600 dark:text-gray-300">
                            <i class="fas fa-check-circle text-green-500 mt-1 flex-shrink-0"></i>
                            <span>Meningkatkan kesadaran dan transparansi bantuan sosial</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Nilai-Nilai Kami -->
<section class="py-20 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4">
        
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Nilai-Nilai Yang Kami Jaga
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-primary-600 to-blue-600 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Kepercayaan -->
            <div class="group text-center">
                <div class="glass-card p-8 rounded-3xl hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-purple-500 to-purple-600 rounded-3xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-transform">
                        <i class="fas fa-handshake text-4xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Kepercayaan</h4>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        Transparansi dan akuntabilitas penuh dalam setiap proses penyaluran bantuan
                    </p>
                </div>
            </div>

            <!-- Keadilan -->
            <div class="group text-center">
                <div class="glass-card p-8 rounded-3xl hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-orange-500 to-orange-600 rounded-3xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-transform">
                        <i class="fas fa-balance-scale text-4xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Keadilan</h4>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        Penyaluran bantuan yang adil, merata, dan tidak memihak kepada siapapun
                    </p>
                </div>
            </div>

            <!-- Inovasi -->
            <div class="group text-center">
                <div class="glass-card p-8 rounded-3xl hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-3xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-transform">
                        <i class="fas fa-lightbulb text-4xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Inovasi</h4>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        Terus berkembang dengan teknologi untuk pelayanan yang lebih baik
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistik Section -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="glass-card rounded-3xl p-12 shadow-2xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Dampak Nyata Yang Kami Ciptakan
                </h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Bersama ribuan relawan dan donatur, kami telah menyalurkan bantuan ke seluruh Indonesia
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-5xl font-extrabold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mb-2">
                        1.2K+
                    </div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Laporan Diterima</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-extrabold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">
                        980+
                    </div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Bantuan Tersalurkan</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-extrabold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                        500+
                    </div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Relawan Aktif</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-extrabold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-2">
                        34
                    </div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Provinsi Terjangkau</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-br from-primary-600 via-primary-700 to-blue-600 dark:from-gray-900 dark:via-primary-900 dark:to-gray-950 py-24">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="space-y-6">
            <h2 class="text-4xl md:text-5xl font-bold text-white">
                Mari Bergabung Bersama Kami
            </h2>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Jadilah bagian dari gerakan kebaikan untuk Indonesia yang lebih baik
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                <a href="{{ route('laporan.create') }}" 
                   class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-primary-700 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-white/30 transform hover:scale-105 transition-all">
                    <i class="fas fa-hands-helping"></i>
                    Mulai Bantu Sekarang
                </a>
                <a href="{{ route('laporan.index') }}" 
                   class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-transparent border-2 border-white text-white rounded-2xl font-bold text-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-list"></i>
                    Lihat Daftar Bantuan
                </a>
            </div>
        </div>
    </div>
</section>

@endsection