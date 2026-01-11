<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Bantuan;
use App\Models\Penyaluran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class DashboardController extends Controller
{
    public function index()
    {
       
        $totalLaporan = Laporan::count();
        $laporanBaru = Laporan::where('status', 'Baru')->count();
        $laporanDiproses = Laporan::where('status', 'Diproses')->count();
        $laporanSelesai = Laporan::where('status', 'Selesai')->count();
        
        $totalBantuan = Bantuan::count(); 
        
        $totalPenyaluran = Penyaluran::count();
        $laporanTerbaru = Laporan::latest()->take(5)->get();

        $jenisStats = Laporan::select('jenis_bantuan', DB::raw('count(*) as total'))
                     ->groupBy('jenis_bantuan')
                     ->pluck('total', 'jenis_bantuan'); 

        return view('dashboard', compact(
            'totalLaporan',
            'laporanBaru',
            'laporanDiproses',
            'laporanSelesai',
            'totalBantuan',
            'totalPenyaluran',
            'laporanTerbaru',
            'jenisStats'
        ));
    }
}