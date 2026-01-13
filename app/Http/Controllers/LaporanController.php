<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('severity') && $request->severity !== 'all') {
            $query->where('severity', $request->severity);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $laporans = $query->paginate(12)->withQueryString();
        return view('laporan.index', compact('laporans'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'severity' => 'required|string',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('reports', 'public');
        }

        Report::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'category' => $request->category,
            'severity' => $request->severity,
            'location' => $request->location,
            'description' => $request->description,
            'image_url' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dikirim dan menunggu verifikasi.');
    }

    public function show($id)
    {
        $laporan = Report::findOrFail($id);
        return view('laporan.show', compact('laporan'));
    }

    public function destroy($id)
    {
        $laporan = Report::findOrFail($id);
        if ($laporan->image_url) {
            Storage::disk('public')->delete($laporan->image_url);
        }
        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}