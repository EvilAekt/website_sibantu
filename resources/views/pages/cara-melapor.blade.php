@extends('layouts.app')

@section('title', 'Cara Melapor - SiBantu')

@section('content')
    <section class="py-12 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Panduan Pelaporan Bencana</h1>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Ikuti langkah mudah berikut untuk membantu
                    sesama yang membutuhkan pertolongan cepat.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <!-- Connecting Line (Desktop) -->
                <div class="hidden md:block absolute top-12 left-[16%] right-[16%] h-1 bg-blue-100 dark:bg-gray-800 -z-10">
                </div>

                <!-- Step 1 -->
                <div
                    class="relative bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 text-center">
                    <div
                        class="w-24 h-24 mx-auto bg-blue-600 text-white rounded-full flex items-center justify-center text-3xl font-bold mb-6 border-4 border-white dark:border-gray-700 shadow-md">
                        1
                    </div>
                    <h3 class="text-xl font-bold mb-3">Foto Kejadian</h3>
                    <p class="text-gray-500 text-sm">Ambil foto kondisi terkini di lokasi bencana. Pastikan gambar jelas dan
                        mewakili keadaan sebenarnya.</p>
                </div>

                <!-- Step 2 -->
                <div
                    class="relative bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 text-center">
                    <div
                        class="w-24 h-24 mx-auto bg-blue-600 text-white rounded-full flex items-center justify-center text-3xl font-bold mb-6 border-4 border-white dark:border-gray-700 shadow-md">
                        2
                    </div>
                    <h3 class="text-xl font-bold mb-3">Isi Formulir</h3>
                    <p class="text-gray-500 text-sm">Buka menu "Laporkan", isi judul, deskripsi, dan pastikan GPS Anda aktif
                        untuk mendeteksi lokasi otomatis.</p>
                </div>

                <!-- Step 3 -->
                <div
                    class="relative bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 text-center">
                    <div
                        class="w-24 h-24 mx-auto bg-blue-600 text-white rounded-full flex items-center justify-center text-3xl font-bold mb-6 border-4 border-white dark:border-gray-700 shadow-md">
                        3
                    </div>
                    <h3 class="text-xl font-bold mb-3">Tunggu Verifikasi</h3>
                    <p class="text-gray-500 text-sm">Laporan Anda akan diperiksa tim admin. Jika valid, bantuan akan segera
                        digalang atau disalurkan.</p>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('laporan.create') }}"
                    class="inline-flex items-center px-8 py-4 bg-blue-600 text-white rounded-full font-bold shadow-lg hover:bg-blue-700 hover:shadow-xl transition transform hover:-translate-y-1">
                    <i class="fas fa-camera mr-2"></i> Mulai Lapor Sekarang
                </a>
            </div>
        </div>
    </section>
@endsection