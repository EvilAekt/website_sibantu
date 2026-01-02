@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="page-container">
    <div class="page-header center">
        <h1>Tentang Kami</h1>
        <p>Mengenal lebih dekat platform Bantuan Masyarakat</p>
    </div>

    <!-- Visi & Misi -->
    <div class="grid-2">
        <div class="info-card">
            <h3><i class="fas fa-eye"></i> Visi Kami</h3>
            <p>
                Menjadi platform terpercaya dalam menghubungkan masyarakat yang membutuhkan
                bantuan dengan sumber daya yang tersedia, serta menciptakan ekosistem kepedulian
                sosial yang berkelanjutan.
            </p>
        </div>

        <div class="info-card">
            <h3><i class="fas fa-bullseye"></i> Misi Kami</h3>
            <ul>
                <li>Mempermudah proses pelaporan bantuan</li>
                <li>Menyalurkan bantuan secara tepat sasaran</li>
                <li>Membangun jaringan relawan peduli</li>
                <li>Meningkatkan kesadaran sosial</li>
            </ul>
        </div>
    </div>

    <!-- Nilai -->
    <div class="section-title">
        <h2>Nilai–Nilai Kami</h2>
    </div>

    <div class="grid-3">
        <div class="value-card">
            <i class="fas fa-handshake"></i>
            <h4>Kepercayaan</h4>
            <p>Transparansi dan akuntabilitas dalam setiap proses.</p>
        </div>

        <div class="value-card">
            <i class="fas fa-balance-scale"></i>
            <h4>Keadilan</h4>
            <p>Penyaluran bantuan yang adil dan merata.</p>
        </div>

        <div class="value-card">
            <i class="fas fa-lightbulb"></i>
            <h4>Inovasi</h4>
            <p>Terus berkembang untuk pelayanan yang lebih baik.</p>
        </div>
    </div>
</div>
@endsection
