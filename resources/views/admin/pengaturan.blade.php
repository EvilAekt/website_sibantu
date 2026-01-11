@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-8">Pengaturan Sistem</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
            <i class="fas fa-user-cog text-primary"></i> Profil Saya
        </h2>
        <form action="#" class="space-y-4">
            <div>
                <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Nama Lengkap</label>
                <input type="text" value="{{ Auth::user()->name ?? 'Admin' }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg p-2.5 text-gray-800 dark:text-white focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Email</label>
                <input type="email" value="{{ Auth::user()->email ?? 'admin@sibantu.com' }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg p-2.5 text-gray-800 dark:text-white focus:ring-2 focus:ring-primary">
            </div>
            <button class="w-full bg-primary hover:bg-blue-800 text-white font-bold py-2 rounded-lg transition">Simpan Perubahan</button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
            <i class="fas fa-sliders-h text-primary"></i> Konfigurasi Aplikasi
        </h2>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div>
                    <div class="font-bold text-gray-800 dark:text-white">Mode Maintenance</div>
                    <div class="text-xs text-gray-500">Matikan akses publik sementara</div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                </label>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div>
                    <div class="font-bold text-gray-800 dark:text-white">Notifikasi Email</div>
                    <div class="text-xs text-gray-500">Kirim email saat ada laporan baru</div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                </label>
            </div>
        </div>
    </div>
</div>
@endsection