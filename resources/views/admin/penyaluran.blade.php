@extends('layouts.admin')

@section('title', 'Riwayat Penyaluran')

@section('content')
{{-- Header --}}
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Riwayat Penyaluran</h1>
    <p class="text-gray-500 dark:text-gray-400 mt-1">Log aktivitas penyaluran bantuan kepada penerima secara real-time.</p>
</div>

{{-- List Penyaluran --}}
<div class="space-y-6">
    @forelse($dataPenyaluran as $item)
        @php
            // Logika Warna Status
            $borderColor = 'border-gray-500';
            $badgeColor = 'bg-gray-100 text-gray-800';
            $icon = 'fa-clock';
            
            if($item->status == 'tersalurkan') {
                $borderColor = 'border-green-500';
                $badgeColor = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                $icon = 'fa-check-circle';
            } elseif($item->status == 'dalam_perjalanan') {
                $borderColor = 'border-yellow-500';
                $badgeColor = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
                $icon = 'fa-truck';
            }
        @endphp

        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border-l-4 {{ $borderColor }} flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:shadow-lg transition transform hover:-translate-y-1 duration-300">
            
            {{-- Kiri: Detail Info --}}
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <span class="{{ $badgeColor }} text-[10px] font-bold px-2 py-0.5 rounded uppercase flex items-center gap-1">
                        <i class="fas {{ $icon }}"></i> {{ str_replace('_', ' ', $item->status) }}
                    </span>
                    <span class="text-gray-400 text-xs flex items-center gap-1">
                        <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($item->tanggal_penyaluran)->translatedFormat('d F Y') }}
                    </span>
                </div>
                
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-1">
                    {{ $item->bantuan->nama_bantuan ?? 'Data Bantuan Terhapus' }}
                </h3>
                
                <div class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                    <p><i class="fas fa-user-tag text-blue-500 w-5"></i> Penerima: <span class="font-semibold">{{ $item->laporan->nama_pelapor ?? 'Tidak Diketahui' }}</span></p>
                    <p><i class="fas fa-user-shield text-purple-500 w-5"></i> Petugas: {{ $item->petugas }}</p>
                </div>
            </div>

            {{-- Kanan: Jumlah & Aksi --}}
            <div class="flex flex-col items-end gap-3 min-w-[120px]">
                <div class="text-right">
                    <div class="text-xs text-gray-500 dark:text-gray-400">Jumlah Disalurkan</div>
                    <div class="text-2xl font-bold text-primary dark:text-blue-400">{{ $item->jumlah }} <span class="text-sm font-normal text-gray-500">Pcs</span></div>
                </div>
                
                @if($item->status == 'tersalurkan')
                    <button class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium flex items-center gap-1 transition">
                        <i class="fas fa-image"></i> Bukti Foto
                    </button>
                @else
                    <span class="text-gray-400 text-xs italic flex items-center gap-1">
                        <i class="fas fa-spinner fa-spin"></i> Proses
                    </span>
                @endif
            </div>
        </div>
    @empty
        {{-- Empty State --}}
        <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700">
            <i class="fas fa-shipping-fast text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
            <p class="text-gray-500 dark:text-gray-400">Belum ada riwayat penyaluran bantuan.</p>
        </div>
    @endforelse
</div>
@endsection