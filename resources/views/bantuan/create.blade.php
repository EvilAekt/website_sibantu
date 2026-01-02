@include('layouts.header')

<div class="form-page">

    <div class="form-card">
        <h2 class="form-title">Tambah Jenis Bantuan</h2>

        <form method="POST" action="/bantuan">
            @csrf

            <div class="form-group">
                <label>Nama Bantuan</label>
                <input type="text" name="nama_bantuan" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi"></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Simpan</button>
                <a href="/bantuan" class="btn-cancel">Batal</a>
            </div>

        </form>
    </div>

</div>

