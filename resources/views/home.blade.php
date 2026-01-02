@extends('layouts.app')

@section('title', 'Beranda - Bantuan Masyarakat')

@section('content')
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Bersama Membantu Sesama</h1>
            <p>Platform pelaporan dan penyaluran bantuan untuk masyarakat yang membutuhkan. Mari bersama-sama menciptakan Indonesia yang lebih peduli.</p>
            <div class="hero-buttons">
                <a href="{{ route('laporan.create') }}" class="btn btn-primary">
                    <i class="fas fa-bullhorn"></i> Laporkan Sekarang
                </a>
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> Lihat Laporan
                </a>
            </div>
        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <h2 class="section-title">Mengapa Memilih Kami?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <h3>Cepat & Responsif</h3>
                <p>Laporan Anda akan segera ditindaklanjuti oleh tim kami dalam waktu 24 jam.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Transparan & Aman</h3>
                <p>Setiap penyaluran bantuan dapat dilacak dan dipertanggungjawabkan.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Berbasis Komunitas</h3>
                <p>Dukungan dari relawan dan masyarakat untuk saling membantu.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Real-time Tracking</h3>
                <p>Pantau status laporan dan bantuan secara langsung.</p>
            </div>
        </div>
    </div>
</section>

<section class="stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">1,234</div>
                <div class="stat-label">Laporan Diterima</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">987</div>
                <div class="stat-label">Bantuan Tersalurkan</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">50+</div>
                <div class="stat-label">Relawan Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">95%</div>
                <div class="stat-label">Tingkat Kepuasan</div>
            </div>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <h2>Butuh Bantuan atau Ingin Membantu?</h2>
        <p>Jangan ragu untuk melaporkan kondisi yang membutuhkan bantuan atau bergabung sebagai relawan.</p>
        <a href="{{ route('laporan.create') }}" class="btn btn-large">
            <i class="fas fa-hand-holding-heart"></i> Mulai Sekarang
        </a>
    </div>
</section>
@endsection