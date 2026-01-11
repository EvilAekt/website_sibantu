<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bantuan;
use App\Models\Penyaluran;

class AdminController extends Controller
{
    // Menampilkan Halaman Data Bantuan
    public function bantuan()
    {
        // Ambil semua data dari tabel bantuan
        $dataBantuan = Bantuan::all(); 
        return view('admin.bantuan', compact('dataBantuan'));
    }

    // Menampilkan Halaman Penyaluran
    public function penyaluran()
    {
        // Ambil data penyaluran beserta relasi nama bantuan & pelapor
        $dataPenyaluran = Penyaluran::with(['bantuan', 'laporan'])->latest()->get();
        return view('admin.penyaluran', compact('dataPenyaluran'));
    }

    // Menampilkan Halaman Pengaturan (Static dulu gapapa)
    public function pengaturan()
    {
        return view('admin.pengaturan');
    }
}