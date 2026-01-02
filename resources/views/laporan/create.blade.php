@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')
<div class="page-wrapper">
    <div class="card-form">
        <h2 class="form-title">
            <i class="fas fa-file-alt"></i> Form Laporan Bantuan
        </h2>
        <p class="form-subtitle">
            Silakan isi laporan dengan data yang benar dan jelas.
        </p>

        <form action="{{ route('laporan.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Judul Laporan</label>
                <input type="text" name="judul" class="form-control" placeholder="Contoh: Bantuan Sembako" required>
            </div>

            <div class="form-group">
                <label>Jenis Bantuan</label>
                <select name="jenis_bantuan" class="form-control" required>
                    <option value="">-- Pilih Jenis Bantuan --</option>
                    <option value="Sembako">Sembako</option>
                    <option value="Uang Tunai">Uang Tunai</option>
                    <option value="Kesehatan">Kesehatan</option>
                    <option value="Pendidikan">Pendidikan</option>
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi Laporan</label>
                <textarea name="deskripsi" rows="5" class="form-control" placeholder="Jelaskan kondisi dan kebutuhan bantuan..." required></textarea>
            </div>

            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="alamat" rows="3" class="form-control" placeholder="Alamat penerima bantuan" required></textarea>
            </div>

            <div class="form-actions">
                <a href="{{ route('laporan.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-paper-plane"></i> Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
