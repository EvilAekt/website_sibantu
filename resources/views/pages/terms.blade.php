@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - SiBantu')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold mb-6">Syarat & Ketentuan</h1>
        <div class="prose dark:prose-invert max-w-none">
            <p>Selamat datang di SiBantu. Dengan menggunakan platform ini, Anda menyetujui syarat dan ketentuan berikut:</p>

            <h3>1. Penggunaan Platform</h3>
            <p>Platform ini bertujuan untuk memfasilitasi pelaporan bencana dan penyaluran bantuan. Pengguna dilarang
                menyalahgunakan platform untuk tujuan penipuan atau penyebaran informasi palsu (hoax).</p>

            <h3>2. Pelaporan Bencana</h3>
            <p>Setiap laporan yang masuk akan diverifikasi oleh tim internal kami. Pelapor wajib menyertakan bukti foto yang
                valid dan lokasi yang akurat.</p>

            <h3>3. Donasi</h3>
            <p>Donasi yang terkumpul akan disalurkan kepada penerima manfaat sesuai dengan kampanye yang dipilih. SiBantu
                berhak memotong biaya operasional sebesar 5% dari total donasi.</p>

            <h3>4. Penarikan Dana</h3>
            <p>Fundraiser hanya dapat menarik dana setelah kampanye diverifikasi dan memenuhi syarat pencairan.</p>
        </div>
    </div>
@endsection