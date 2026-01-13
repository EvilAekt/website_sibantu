@extends('layouts.dashboard')

@section('title', 'Riwayat Penarikan - SiBantu')

@section('header')
    <div class="flex justify-between items-center">
        <div class="flex flex-col">
            <h1 class="text-xl font-bold text-gray-800 dark:text-white">Riwayat Penarikan Dana</h1>
            <p class="text-xs text-gray-500">Pantau status pencairan dana kampanye Anda</p>
        </div>
        <!-- Trigger Modal Penarikan (Optional, usually on Dashboard) -->
    </div>
@endsection

@section('content')
    <!-- Withdrawal List -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        @if(isset($withdrawals) && $withdrawals->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Jumlah</th>
                            <th class="px-6 py-3">Bank Tujuan</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($withdrawals as $withdrawal)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $withdrawal->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-800 dark:text-gray-200">
                                    Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs">
                                        <div class="font-bold text-gray-700 dark:text-gray-300">{{ $withdrawal->bank_name }}</div>
                                        <div class="text-gray-500">{{ $withdrawal->account_number }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($withdrawal->status == 'approved')
                                        <span
                                            class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded border border-green-200">
                                            Berhasil
                                        </span>
                                    @elseif($withdrawal->status == 'pending')
                                        <span
                                            class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded border border-yellow-200">
                                            Menunggu
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded border border-red-200">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-gray-500 text-xs">
                                    {{ $withdrawal->notes ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                {{ $withdrawals->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                    <i class="fas fa-wallet text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Belum Ada Penarikan</h3>
                <p class="text-gray-500 text-sm mt-1">Anda belum melakukan permintaan pencairan dana.</p>
            </div>
        @endif
    </div>
@endsection