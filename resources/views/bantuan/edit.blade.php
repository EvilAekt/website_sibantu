@include('layouts.header')

@section('content')
<section class="form-section">
    <div class="container">
        <div class="form-container">

            <form action="{{ route('bantuan.update', $bantuan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Bantuan *</label>
                    <input type="text" name="nama_bantuan"
                        class="form-control"
                        value="{{ old('nama_bantuan', $bantuan->nama_bantuan) }}" required>
                </div>

                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="kategori" class="form-control" required>
                        @foreach(['pangan','sandang','papan','kesehatan','pendidikan','lainnya'] as $kat)
                            <option value="{{ $kat }}"
                                {{ old('kategori', $bantuan->kategori) == $kat ? 'selected' : '' }}>
                                {{ ucfirst($kat) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Stok *</label>
                    <input type="number" name="stok"
                        class="form-control"
                        value="{{ old('stok', $bantuan->stok) }}" min="0" required>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="4">{{ old('keterangan', $bantuan->keterangan) }}</textarea>
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('bantuan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>

        </div>
    </div>
</section>
