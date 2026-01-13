@extends('layouts.app')

@section('title', 'FAQ - SiBantu')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold mb-8 text-center">Frequently Asked Questions</h1>

        <div class="space-y-4" x-data="{ active: null }">
            <!-- Item 1 -->
            <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                <button @click="active === 1 ? active = null : active = 1"
                    class="w-full flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <span class="font-semibold text-left">Bagaimana cara melaporkan bencana?</span>
                    <i class="fas" :class="active === 1 ? 'fa-minus' : 'fa-plus'"></i>
                </button>
                <div x-show="active === 1" x-collapse
                    class="p-4 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                    <p>Klik menu "Laporkan" di navigasi atas, isi formulir dengan judul, deskripsi, upload foto bukti, dan
                        pastikan lokasi GPS aktif. Tim kami akan memverifikasinya.</p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                <button @click="active === 2 ? active = null : active = 2"
                    class="w-full flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <span class="font-semibold text-left">Apakah donasi saya aman?</span>
                    <i class="fas" :class="active === 2 ? 'fa-minus' : 'fa-plus'"></i>
                </button>
                <div x-show="active === 2" x-collapse
                    class="p-4 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                    <p>Ya, sangat aman. Kami bekerjasama dengan payment gateway terpercaya dan setiap penyaluran dana akan
                        dilaporkan secara transparan di halaman kampanye.</p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                <button @click="active === 3 ? active = null : active = 3"
                    class="w-full flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <span class="font-semibold text-left">Berapa lama proses verifikasi laporan?</span>
                    <i class="fas" :class="active === 3 ? 'fa-minus' : 'fa-plus'"></i>
                </button>
                <div x-show="active === 3" x-collapse
                    class="p-4 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                    <p>Maksimal 1x24 jam. Untuk kondisi darurat, tim kami akan memprioritaskan verifikasi dalam hitungan
                        jam.</p>
                </div>
            </div>
        </div>
    </div>
@endsection