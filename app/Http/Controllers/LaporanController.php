<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::query();

        if ($request->filled('jenis')) {
            $query->where('jenis_bantuan', $request->jenis);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_pelapor', 'like', "%{$request->search}%")
                  ->orWhere('lokasi', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $laporan = $query->latest()->paginate(10);

        if ($request->expectsJson()) {
            return response()->json([
                'html' => view('laporan.partials.list', compact('laporan'))->render(),
                'pagination' => $laporan->render()
            ]);
        }

        return view('laporan.index', compact('laporan'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_pelapor'   => 'required|string|max:255',
                'lokasi'         => 'required|string|max:255',
                'deskripsi'      => 'required|string',
                'jenis_bantuan'  => 'required|in:pangan,sandang,papan,kesehatan,pendidikan,lainnya',
                'foto'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('laporan', 'public');
            }

            $validated['tracking_code'] = strtoupper(Str::random(10));
            $validated['status'] = 'baru'; // ✅ konsisten huruf kecil

            $laporan = Laporan::create($validated);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Laporan berhasil dikirim!',
                    'data' => $laporan
                ]);
            }

            return redirect()
                ->route('laporan.index')
                ->with('success', 'Laporan berhasil dikirim!');

        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }
    }

    public function show(Laporan $laporan)
    {
        $laporan->load('penyaluran.bantuan');
        return view('laporan.show', compact('laporan'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status' => 'required|in:baru,diproses,selesai' // ✅ huruf kecil
        ]);

        $laporan->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diupdate!',
            'data' => $laporan
        ]);
    }

    public function destroy(Laporan $laporan)
    {
        if ($laporan->foto) {
            Storage::disk('public')->delete($laporan->foto);
        }
        $laporan->delete();

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }

    public function exportCSV(): StreamedResponse
    {
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'ID', 'Tracking Code', 'Nama Pelapor', 'Lokasi',
                'Deskripsi', 'Jenis Bantuan', 'Status', 'Tanggal'
            ]);

            Laporan::chunk(100, function ($items) use ($handle) {
                foreach ($items as $row) {
                    fputcsv($handle, [
                        $row->id,
                        $row->tracking_code,
                        $row->nama_pelapor,
                        $row->lokasi,
                        $row->deskripsi,
                        $row->jenis_bantuan,
                        ucfirst($row->status), // tampilan rapi
                        $row->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
            fclose($handle);
        }, 'laporan_' . now()->format('YmdHis') . '.csv');
    }
}