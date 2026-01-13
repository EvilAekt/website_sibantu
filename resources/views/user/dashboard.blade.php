@extends('layouts.dashboard')

@section('title', 'Dashboard Saya - SiBantu')

@section('header')
<div class="flex flex-col">
    <h1 class="text-xl font-bold text-gray-800 dark:text-white">Dashboard Donatur</h1>
    <p class="text-xs text-gray-500">Pantau jejak kebaikan Anda</p>
</div>
@endsection

@section('content')
    <!-- Hero Section: Warm Welcome -->
    <div class="relative bg-gradient-to-r from-blue-500 to-indigo-600 rounded-3xl p-8 mb-8 text-white overflow-hidden shadow-xl">
        <div class="absolute right-0 top-0 h-full w-1/2 bg-[url('https://source.unsplash.com/random/800x600/?kindness,help')] bg-cover opacity-10 mix-blend-overlay"></div>
        <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-2xl">
            <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold mb-3 border border-white/30">
                👋 Halo, Orang Baik!
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold mb-2 leading-tight">
                Selamat Datang Kembali, {{ explode(' ', auth()->user()->name)[0] }}!
            </h2>
            <p class="text-blue-100 text-lg mb-6 leading-relaxed">
                Setiap donasi Anda adalah harapan baru bagi mereka yang membutuhkan. Terima kasih telah memilih untuk peduli hari ini.
            </p>
            <div class="flex gap-4">
                <a href="{{ route('campaigns.index') }}" class="px-6 py-3 bg-white text-blue-600 rounded-xl font-bold shadow-lg hover:bg-blue-50 transition transform hover:-translate-y-1">
                    Mulai Berdonasi
                </a>
                <a href="#history" class="px-6 py-3 bg-blue-700/50 text-white rounded-xl font-bold hover:bg-blue-700/70 transition backdrop-blur-md">
                    Lihat Jejak Kebaikan
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Overview (Minimalist) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Total Impact -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:border-blue-200 transition">
            <div class="flex flex-col h-full justify-between relative z-10">
                <div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Total Donasi Anda</p>
                    <h3 class="text-3xl font-extrabold text-gray-800 dark:text-white">
                        Rp {{ number_format($totalDonated ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="mt-4 flex items-center gap-2 text-sm text-green-600 font-medium bg-green-50 w-fit px-2 py-1 rounded-lg">
                    <i class="fas fa-arrow-up"></i> Terus bertambah
                </div>
            </div>
            <div class="absolute right-[-10px] bottom-[-10px] text-blue-50 opacity-50 dark:opacity-5 group-hover:scale-110 transition-transform">
                <i class="fas fa-hand-holding-heart text-9xl"></i>
            </div>
        </div>

        <!-- Campaigns Supported -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:border-purple-200 transition">
             <div class="flex flex-col h-full justify-between relative z-10">
                <div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Kampanye Didukung</p>
                    <h3 class="text-3xl font-extrabold text-gray-800 dark:text-white">
                        {{ $campaignsSupported ?? 0 }}
                    </h3>
                </div>
                 <div class="mt-4 text-sm text-gray-500">
                    Program kebaikan yang telah Anda bantu wujudkan.
                </div>
            </div>
             <div class="absolute right-4 top-1/2 -translate-y-1/2 w-16 h-16 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-3xl group-hover:rotate-12 transition-transform">
                <i class="fas fa-hands-helping"></i>
            </div>
        </div>

        <!-- Monthly Impact -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:border-green-200 transition">
             <div class="flex flex-col h-full justify-between relative z-10">
                <div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Donasi Bulan Ini ({{ now()->format('M') }})</p>
                    <h3 class="text-3xl font-extrabold text-gray-800 dark:text-white">
                        Rp {{ number_format($monthlyDonated ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="mt-4 w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-green-500 h-1.5 rounded-full" style="width: 70%"></div>
                </div>
            </div>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 w-16 h-16 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-3xl group-hover:rotate-12 transition-transform">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>
    </div>

    <!-- Main Content: History & Recommendations -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" id="history">
        
        <!-- Left Column: History Table (Span 2) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-8 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Riwayat Kebaikan</h2>
                        <p class="text-sm text-gray-500">Jejak donasi terbaru Anda</p>
                    </div>
                </div>

                @if($donations->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kampanye</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-8 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Invoice</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($donations->take(5) as $donation)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm flex-shrink-0">
                                                {{ substr($donation->campaign->title ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800 dark:text-white line-clamp-1 max-w-[200px]">{{ $donation->campaign->title ?? 'N/A' }}</p>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700">
                                                    Berhasil
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-sm text-gray-500">
                                        {{ $donation->created_at->format('d M Y') }}
                                        <p class="text-xs text-gray-400">{{ $donation->created_at->format('H:i') }} WIB</p>
                                    </td>
                                    <td class="px-8 py-5 font-bold text-gray-800 dark:text-white">
                                        Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <button class="text-gray-400 hover:text-blue-600 transition p-2 hover:bg-blue-50 rounded-lg" title="Download Invoice">
                                            <i class="fas fa-file-download text-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 text-center">
                        <a href="{{ route('user.history') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 hover:underline">
                            Lihat Semua Riwayat
                        </a>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-4 text-gray-400">
                            <i class="fas fa-receipt text-3xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Belum ada donasi</h3>
                        <p class="text-gray-500 text-sm max-w-sm mx-auto mb-6">Mulai perjalanan kebaikan Anda hari ini. Sekecil apapun bantuan Anda sangat berarti.</p>
                        <a href="{{ route('campaigns.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition">
                            Cari Program Kebaikan
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Recommendations (Span 1) -->
        <div class="space-y-6">
            <!-- Recommendation Card -->
            <div class="bg-blue-50 dark:bg-gray-800/80 rounded-3xl p-6 border border-blue-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 dark:text-white">Rekomendasi Untuk Anda</h3>
                </div>
                
                <div class="space-y-4">
                    <!-- Dummy Recommendation (Ideally dynamic) -->
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition cursor-pointer group">
                        <div class="h-32 bg-gray-200 rounded-lg mb-3 overflow-hidden relative">
                             <img src="https://source.unsplash.com/random/400x300/?children" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                             <div class="absolute top-2 left-2 bg-white/90 px-2 py-0.5 rounded text-xs font-bold text-blue-600">Pendidikan</div>
                        </div>
                        <h4 class="font-bold text-gray-800 dark:text-white text-sm line-clamp-2 mb-2 group-hover:text-blue-600 transition">
                            Bantu Adik Budi Melanjutkan Sekolahnya yang Terputus
                        </h4>
                        <div class="w-full bg-gray-100 rounded-full h-1.5 mb-2">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: 45%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Terkumpul 45%</span>
                            <span class="font-bold text-gray-700 dark:text-gray-300">Sisa 5 hari</span>
                        </div>
                    </div>

                     <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition cursor-pointer group">
                         <div class="flex gap-4">
                             <div class="w-20 h-20 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                   <img src="https://source.unsplash.com/random/200x200/?disaster" class="w-full h-full object-cover">
                             </div>
                             <div>
                                 <h4 class="font-bold text-gray-800 dark:text-white text-sm line-clamp-2 mb-1 group-hover:text-blue-600 transition">
                                     Darurat: Banjir Bandang di Desa Sukamaju
                                 </h4>
                                 <p class="text-xs text-gray-500 mb-2">Bencana Alam</p>
                                 <button class="text-xs font-bold text-blue-600 hover:underline">Lihat Detail</button>
                             </div>
                         </div>
                     </div>
                </div>
            </div>

            <!-- Quote Card -->
            <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-3xl p-6 text-white relative overflow-hidden">
                <i class="fas fa-quote-left absolute top-4 left-4 text-white/20 text-6xl"></i>
                <p class="relative z-10 font-medium italic text-lg mb-4 text-center">
                    "Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia lainnya."
                </p>
                <div class="text-center opacity-80 text-sm font-semibold">
                    - HR. Ahmad
                </div>
            </div>
        </div>
    </div>
@endsection