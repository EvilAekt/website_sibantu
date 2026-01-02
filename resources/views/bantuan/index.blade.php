@extends('layouts.app')

@section('title', 'Daftar Bantuan - Bantuan Masyarakat')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header Biru -->
        <div class="bg-blue-700 text-white rounded-t-lg p-8 text-center">
            <h1 class="text-3xl font-bold mb-2">Daftar Bantuan</h1>
            <p class="text-blue-100">Lihat semua bantuan yang tersedia untuk masyarakat yang membutuhkan.</p>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-b-lg shadow-md p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div>
                    <input type="text" placeholder="Cari nama atau lokasi..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <select
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>Semua Jenis</option>
                        <option>Makanan</option>
                        <option>Pakaian</option>
                        <option>Kesehatan</option>
                    </select>
                </div>
                <div>
                    <select
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>Semua Status</option>
                        <option>Diterima</option>
                        <option>Diproses</option>
                        <option>Selesai</option>
                    </select>
                </div>
                <div>
                    <input type="date"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg flex items-center">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>
        </div>

        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-16 bg-gray-50 rounded-lg mt-8">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-box-open text-6xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada bantuan tersedia</h3>
            <p class="text-gray-500 mb-6">Bantuan belum tersedia saat ini. Silakan cek kembali nanti.</p>

            <!-- Tombol "Laporkan Sekarang" yang diperbaiki -->
            <a href="{{ route('laporan.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg flex items-center transition duration-300">
                <i class="fas fa-bullhorn mr-2"></i> Laporkan Kebutuhan Bantuan
            </a>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush
