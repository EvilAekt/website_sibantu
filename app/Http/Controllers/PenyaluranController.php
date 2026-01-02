<?php

namespace App\Http\Controllers;

use App\Models\Bantuan;
use App\Models\Laporan;
use App\Models\Penyaluran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenyaluranController extends Controller
{
    public function create()
    {
        $laporan = Laporan::where('status', 'disetujui')->get();
        $bantuan = Bantuan::where('stok', '>', 0)->get();

        return view('penyaluran.create', compact('laporan', 'bantuan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_laporan'         => 'required|exists:laporans,id',
            'id_bantuan'         => 'required|exists:bantuans,id',
            'jumlah'             => 'required|integer|min:1',
            'tanggal_penyaluran' => 'required|date',
            'petugas'            => 'required|string',
        ]);

        DB::transaction(function () use ($validated) {

            $bantuan = Bantuan::lockForUpdate()
                ->findOrFail($validated['id_bantuan']);

            if ($validated['jumlah'] > $bantuan->stok) {
                throw new \Exception('Stok tidak mencukupi');
            }

            Penyaluran::create($validated);

            $bantuan->decrement('stok', $validated['jumlah']);
        });

        return redirect()->route('penyaluran.index')
            ->with('success', 'Penyaluran berhasil dijadwalkan');
    }
}
