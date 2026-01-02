<?php

namespace App\Http\Controllers;

use App\Models\Bantuan;
use Illuminate\Http\Request;

class BantuanController extends Controller
{
    public function index()
    {
        // WAJIB paginate agar bisa pakai ->links() di blade
        $bantuan = Bantuan::latest()->paginate(10);

        return view('bantuan.index', compact('bantuan'));
    }

    public function create()
    {
        return view('bantuan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bantuan' => 'required|string|max:255',
            'kategori'     => 'required|in:pangan,sandang,papan,kesehatan,pendidikan,lainnya',
            'stok'         => 'required|integer|min:0',
            'keterangan'   => 'nullable|string',
        ]);

        Bantuan::create($validated);

        return redirect()
            ->route('bantuan.index')
            ->with('success', 'Bantuan berhasil ditambahkan');
    }

    public function edit(Bantuan $bantuan)
    {
        return view('bantuan.edit', compact('bantuan'));
    }

    public function update(Request $request, Bantuan $bantuan)
    {
        $validated = $request->validate([
            'nama_bantuan' => 'required|string|max:255',
            'kategori'     => 'required|in:pangan,sandang,papan,kesehatan,pendidikan,lainnya',
            'stok'         => 'required|integer|min:0',
            'keterangan'   => 'nullable|string',
        ]);

        $bantuan->update($validated);

        return redirect()
            ->route('bantuan.index')
            ->with('success', 'Bantuan berhasil diperbarui');
    }

    public function destroy(Bantuan $bantuan)
    {
        $bantuan->delete();

        return redirect()
            ->route('bantuan.index')
            ->with('success', 'Bantuan berhasil dihapus');
    }
}
