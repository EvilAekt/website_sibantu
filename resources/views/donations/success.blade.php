@extends('layouts.app')

@section('title', 'Donasi Berhasil - SiBantu')

@section('content')
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-16 flex items-center justify-center">
        <div class="container mx-auto px-4">
            <div
                class="max-w-lg mx-auto bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 md:p-12 text-center relative overflow-hidden">
                <!-- Confetti Background (CSS only approximation) -->
                <div class="absolute inset-0 pointer-events-none">
                    <div
                        class="absolute top-0 left-0 w-full h-full opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-blue-400 via-transparent to-transparent">
                    </div>
                </div>

                <!-- Icon -->
                <div
                    class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                    <i class="fas fa-check text-4xl text-green-600 dark:text-green-400"></i>
                </div>

                <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Terima Kasih!</h1>
                <p class="text-gray-500 dark:text-gray-400 mb-8">Donasi Anda telah berhasil kami terima.</p>

                <!-- Transaction Details -->
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 mb-8 text-left">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">ID Transaksi</span>
                        <span
                            class="font-mono text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $transaction->transaction_code }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Tanggal</span>
                        <span
                            class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Metode</span>
                        <span
                            class="text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">{{ str_replace('_', ' ', $transaction->payment_method) }}</span>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-600 my-3"></div>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-800 dark:text-white">Total Donasi</span>
                        <span class="text-xl font-bold text-blue-600">Rp
                            {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('campaigns.show', $transaction->campaign->slug) }}"
                        class="block w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition">
                        Kembali ke Campaign
                    </a>
                    <a href="{{ route('user.history') }}"
                        class="block w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold py-3 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        Lihat Riwayat Donasi
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection