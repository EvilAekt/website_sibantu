@extends('layouts.dashboard')

@section('title', 'Riwayat Donasi - SiBantu')

@section('breadcrumb')
    <span class="text-gray-700 dark:text-gray-300">Riwayat Donasi</span>
@endsection

@section('content')
<!-- Header -->
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 dark:text-white">Riwayat Donasi</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Semua riwayat transaksi donasi Anda</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 mb-6">
    <form method="GET" action="{{ route('user.history') }}" class="flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[150px]">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
            <select name="status" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 text-sm">
                <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Semua Status</option>
                <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Berhasil</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Gagal</option>
            </select>
        </div>
        <div class="min-w-[140px]">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dari Tanggal</label>
            <input type="date" name="from" value="{{ request('from') }}" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 text-sm">
        </div>
        <div class="min-w-[140px]">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sampai Tanggal</label>
            <input type="date" name="to" value="{{ request('to') }}" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 text-sm">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
            <a href="{{ route('user.history') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Donations Table -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <span class="text-sm text-gray-500">Total: <strong class="text-gray-800 dark:text-white">{{ $donations->total() }}</strong> transaksi</span>
    </div>
    
    @if($donations->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Campaign</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($donations as $donation)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold flex-shrink-0">
                                        {{ substr($donation->campaign->title ?? 'N', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-white line-clamp-1">{{ $donation->campaign->title ?? 'Campaign Tidak Ditemukan' }}</p>
                                        <p class="text-xs text-gray-500">{{ $donation->transaction_code }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-800 dark:text-white text-sm">{{ $donation->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $donation->created_at->format('H:i') }} WIB</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-800 dark:text-white">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($donation->status === 'success')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        <i class="fas fa-check w-3 h-3 mr-1"></i> Berhasil
                                    </span>
                                @elseif($donation->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        <i class="fas fa-clock w-3 h-3 mr-1"></i> Menunggu
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                        <i class="fas fa-times w-3 h-3 mr-1"></i> Gagal
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($donation->campaign)
                                    <a href="{{ route('campaigns.show', $donation->campaign->slug) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Lihat Campaign
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $donations->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-20 h-20 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-history text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Tidak Ada Data</h3>
            <p class="text-gray-500 mb-6">Tidak ada transaksi yang sesuai dengan filter.</p>
            <a href="{{ route('campaigns.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                <i class="fas fa-search mr-2"></i> Jelajahi Campaign
            </a>
        </div>
    @endif
</div>
@endsection
