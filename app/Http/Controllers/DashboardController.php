<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Bantuan;
use App\Models\Penyaluran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLaporan = Laporan::count();

        $laporanBaru = Laporan::where('status', 'Baru')->count();
        $laporanDiproses = Laporan::where('status', 'Diproses')->count();
        $laporanSelesai = Laporan::where('status', 'Selesai')->count();

        $totalBantuan = Bantuan::sum('stok');

        $bantuanTersalurkan = Penyaluran::where('status', 'Diterima')->count();

        $laporanTerbaru = Laporan::latest()->take(5)->get();
        $bantuanList = Bantuan::orderBy('stok', 'asc')->take(5)->get();

        return view('dashboard.index', compact(
            'totalLaporan',
            'laporanBaru',
            'laporanDiproses',
            'laporanSelesai',
            'totalBantuan',
            'bantuanTersalurkan',
            'laporanTerbaru',
            'bantuanList'
        ));
    }
}
