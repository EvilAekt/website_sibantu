@include('layouts.header')

<h2 class="text-2xl font-bold mb-6">Catat Penyaluran Bantuan</h2>

<form method="POST" action="/penyaluran">
    @csrf
    <div class="mb-4">
        <label class="block mb-2">Kaitkan dengan Laporan (Opsional)</label>
        <select name="report_id" class="w-full border px-3 py-2 rounded">
            <option value="">-- Bantuan Umum --</option>
            @foreach($reports as $r)
                <option value="{{ $r->id }}">
                    {{ $r->nama_pelapor }} - {{ $r->lokasi }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block mb-2">Jenis Bantuan</label>
        <select name="assistance_type_id" class="w-full border px-3 py-2 rounded" required>
            @foreach($types as $t)
                <option value="{{ $t->id }}">{{ $t->nama_bantuan }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block mb-2">Jumlah (Opsional)</label>
        <input type="number" name="jumlah" min="1" class="w-full border px-3 py-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block mb-2">Lokasi Penyaluran</label>
        <input type="text" name="lokasi" class="w-full border px-3 py-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block mb-2">Tanggal Penyaluran</label>
        <input type="date" name="tanggal_penyaluran" class="w-full border px-3 py-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block mb-2">Keterangan</label>
        <textarea name="keterangan" class="w-full border px-3 py-2 rounded"></textarea>
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan Penyaluran</button>
</form>

@include('layouts.footer')