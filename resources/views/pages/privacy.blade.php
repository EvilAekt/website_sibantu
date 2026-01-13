@extends('layouts.app')

@section('title', 'Kebijakan Privasi - SiBantu')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold mb-6">Kebijakan Privasi</h1>
        <div class="prose dark:prose-invert max-w-none">
            <p>Kami di SiBantu sangat menghargai privasi Anda. Dokumen ini menjelaskan bagaimana kami mengumpulkan dan
                menggunakan data pribadi Anda.</p>

            <h3>1. Data yang Kami Kumpulkan</h3>
            <ul class="list-disc pl-5">
                <li>Nama lengkap dan alamat email saat pendaftaran.</li>
                <li>Lokasi GPS saat membuat laporan bencana.</li>
                <li>Informasi transaksi saat melakukan donasi (kami tidak menyimpan nomor kartu kredit/CVV).</li>
            </ul>

            <h3>2. Penggunaan Data</h3>
            <p>Data digunakan untuk verifikasi laporan, mengirim notifikasi donasi, dan meningkatkan layanan platform.</p>

            <h3>3. Keamanan Data</h3>
            <p>Kami menggunakan enkripsi SSL untuk melindungi data Anda selama transmisi. Akses ke data pribadi dibatasi
                hanya untuk staf yang berwenang.</p>
        </div>
    </div>
@endsection