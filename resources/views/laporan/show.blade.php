@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('laporan.index') }}"
            class="inline-flex items-center mb-6 text-blue-600 hover:text-blue-800 transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="relative h-64 md:h-80 bg-gray-200">
                <img src="{{ asset('storage/' . $laporan->image_url) }}" class="w-full h-full object-cover"
                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($laporan->user->name ?? 'Anonim') }}&background=1e3a8a&color=fff&size=500';">
                <div class="absolute top-4 right-4">
                    <span
                        class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg uppercase tracking-wide">
                        {{ $laporan->status }}
                    </span>
                </div>
            </div>

            <div class="p-8">
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b border-gray-100 pb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $laporan->title ?? 'Laporan Bantuan' }}</h1>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1"><i class="far fa-user"></i>
                                {{ $laporan->user->name ?? 'Anonim' }}</span>
                            <span class="flex items-center gap-1"><i class="far fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($laporan->created_at)->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg font-semibold border border-blue-100">
                            <i class="fas fa-box-open mr-1"></i> Bantuan
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="md:col-span-2 space-y-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                                <i class="fas fa-align-left text-blue-500"></i> Deskripsi Masalah
                            </h3>
                            <p class="text-gray-600 leading-relaxed whitespace-pre-line">
                                {{ $laporan->description }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-red-500"></i> Lokasi & Alamat
                            </h3>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-gray-700">
                                {{ $laporan->location }}
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl h-fit border border-gray-200">
                        <h4 class="font-bold text-gray-700 mb-4 border-b border-gray-200 pb-2">Informasi Status</h4>

                        <ul class="space-y-4 text-sm">
                            <li class="flex justify-between">
                                <span class="text-gray-500">ID Laporan</span>
                                <span class="font-mono font-bold">#{{ $laporan->id }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-gray-500">Dibuat</span>
                                <span class="font-medium">{{ $laporan->created_at->diffForHumans() }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-gray-500">Status Terkini</span>
                                <span class="font-bold text-blue-600">{{ ucfirst($laporan->status) }}</span>
                            </li>
                        </ul>

                        @auth
                            <div class="mt-6 pt-6 border-t border-gray-200 space-y-2">
                                <button
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition font-medium">
                                    Proses Laporan
                                </button>
                                <button
                                    class="w-full bg-white hover:bg-red-50 text-red-600 border border-red-200 py-2 rounded-lg transition font-medium">
                                    Hapus Laporan
                                </button>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection