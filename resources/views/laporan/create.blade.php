@extends('layouts.app')

@section('title', 'Buat Laporan Baru')

@section('content')

{{-- 1. STYLE CSS KHUSUS HALAMAN INI (Animasi & Input) --}}
<style>
    /* Keyframes Animasi Fade In Up */
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

{{-- 2. HEADER SECTION (Background Sesuai Index & Animasi) --}}
<section class="rounded-b-[3rem] relative bg-gradient-to-br from-primary-600 via-primary-700 to-blue-600 dark:from-gray-900 dark:via-primary-900 dark:to-gray-950 py-24 overflow-hidden">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl font-bold text-white mb-2">Buat Laporan Baru</h1>
        <p class="text-blue-100 opacity-90 text-sm">Silakan isi formulir di bawah ini dengan data yang valid.</p>
    </div>
</section>

{{-- 3. FORM CONTAINER (Animasi Delay) --}}
<div class="container mx-auto px-4 -mt-16 pb-12 relative z-10 animate-fade-in" style="animation-delay: 0.2s;">
    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden hover-lift">
        
        {{-- Header Form --}}
        <div class="bg-gray-50 dark:bg-gray-700/50 px-8 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
            <span class="text-gray-500 dark:text-gray-300 font-medium text-sm flex items-center">
                <i class="fas fa-info-circle mr-2 text-blue-500"></i> Data Penerima Bantuan
            </span>
            <a href="{{ route('laporan.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold dark:text-blue-400 transition-colors flex items-center">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        {{-- Form Body --}}
        <div class="p-8">
            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    
                    {{-- Input Judul --}}
                    <div class="col-span-2 md:col-span-1 relative">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Judul Laporan / Nama</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3.5 text-gray-400 dark:text-gray-500"><i class="fas fa-heading"></i></span>
                            <input type="text" name="nama_pelapor" 
                                   class="w-full pl-10 pr-4 py-3 rounded-lg glass-input text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none" 
                                   placeholder="Contoh: Bantuan Sembako Warga..." required>
                        </div>
                    </div>

                    {{-- Input Jenis Bantuan --}}
                    <div class="col-span-2 md:col-span-1 relative">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Jenis Bantuan</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3.5 text-gray-400 dark:text-gray-500"><i class="fas fa-box"></i></span>
                            <select name="jenis_bantuan" class="w-full pl-10 pr-8 py-3 rounded-lg glass-input text-sm cursor-pointer appearance-none dark:bg-gray-800/50" required>
                                <option value="" class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">-- Pilih Jenis --</option>
                                <option value="pangan" class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Sembako</option>
                                <option value="sandang" class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Uang Tunai</option>
                                <option value="kesehatan" class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Kesehatan</option>
                                <option value="pendidikan" class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Pendidikan</option>
                                <option value="lainnya" class="text-gray-800 dark:bg-gray-800 dark:text-gray-200">Lainnya</option>
                            </select>
                            <span class="absolute right-3 top-3.5 text-gray-400 dark:text-gray-500 pointer-events-none"><i class="fas fa-chevron-down text-xs"></i></span>
                        </div>
                    </div>

                    {{-- Input Lokasi --}}
                    <div class="col-span-2 relative">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Lokasi Lengkap</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3.5 text-gray-400 dark:text-gray-500"><i class="fas fa-map-marker-alt"></i></span>
                            <textarea name="lokasi" rows="2" 
                                      class="w-full pl-10 pr-4 py-3 rounded-lg glass-input text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none" 
                                      placeholder="Nama Jalan, RT/RW, Kelurahan..." required></textarea>
                        </div>
                    </div>

                    {{-- Input Deskripsi --}}
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Deskripsi Kondisi</label>
                        <textarea name="deskripsi" rows="4" 
                                  class="w-full px-4 py-3 rounded-lg glass-input text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none" 
                                  placeholder="Jelaskan secara detail mengapa bantuan ini dibutuhkan..." required></textarea>
                    </div>

                    {{-- Upload Foto --}}
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Foto Bukti (Opsional)</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 border-gray-300 dark:border-gray-600 hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-300 group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 group-hover:text-blue-500 transition-colors mb-2"></i>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 2MB)</p>
                                </div>
                                <input id="dropzone-file" type="file" name="foto" class="hidden" />
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Tombol Submit (Animated) --}}
                <div class="mt-8">
                    <button type="submit" class="group relative w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-blue-500/30 transition transform hover:-translate-y-1 flex justify-center items-center gap-2 overflow-hidden">
                        {{-- Efek Kilau --}}
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                        
                        <i class="fas fa-paper-plane text-lg"></i> 
                        <span class="tracking-wide">Kirim Laporan Sekarang</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection