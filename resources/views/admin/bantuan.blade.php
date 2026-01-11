@extends('layouts.admin')

@section('title', 'Data Bantuan')

@section('content')
{{-- Header --}}
<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Stok Bantuan</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola ketersediaan logistik bantuan.</p>
    </div>
    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition flex items-center gap-2 transform hover:scale-105">
        <i class="fas fa-plus"></i> Tambah Stok
    </button>
</div>

{{-- Statistik Ringkas (Bisa dibuat dinamis nanti, sekarang statis dulu biar rapi) --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 border-blue-500">
        <div class="text-gray-500 text-sm">Total Jenis Bantuan</div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $dataBantuan->count() }} Jenis</div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 border-green-500">
        <div class="text-gray-500 text-sm">Stok Aman (>100)</div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $dataBantuan->where('stok', '>', 100)->count() }} Item</div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 border-red-500">
        <div class="text-gray-500 text-sm">Stok Menipis (<50)</div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $dataBantuan->where('stok', '<', 50)->count() }} Item</div>
    </div>
</div>

{{-- Tabel Data --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 uppercase text-xs font-bold tracking-wider">
                <tr>
                    <th class="px-6 py-4">Nama Bantuan</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Stok</th>
                    <th class="px-6 py-4">Keterangan</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($dataBantuan as $item)
                <tr class="hover:bg-blue-50 dark:hover:bg-gray-700/50 transition duration-150">
                    <td class="px-6 py-4 font-bold text-gray-800 dark:text-white">
                        {{ $item->nama_bantuan }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 border border-blue-200 dark:border-blue-800">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->stok < 50)
                            <span class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 px-3 py-1 rounded-full text-xs font-bold animate-pulse">
                                {{ $item->stok }}
                            </span>
                        @else
                            <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-3 py-1 rounded-full text-xs font-bold">
                                {{ $item->stok }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                        {{ Str::limit($item->keterangan, 40) ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <button class="p-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition"><i class="fas fa-edit"></i></button>
                            <button class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-box-open text-4xl mb-2 opacity-50"></i>
                            <p>Belum ada data bantuan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection