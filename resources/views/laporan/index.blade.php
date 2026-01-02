@extends('layouts.app')

@section('title', 'Daftar Laporan')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Daftar Laporan Bantuan</h1>
        <p>Lihat semua laporan yang masuk ke sistem</p>
    </div>
</section>

<section class="laporan-list">
    <div class="container">
        <div class="filter-section">
            <div class="filter-group">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari nama atau lokasi...">
                <select id="jenisFilter" class="form-control">
                    <option value="">Semua Jenis</option>
                    <option value="pangan">Pangan</option>
                    <option value="sandang">Sandang</option>
                    <option value="papan">Papan</option>
                    <option value="kesehatan">Kesehatan</option>
                    <option value="pendidikan">Pendidikan</option>
                    <option value="lainnya">Lainnya</option>
                </select>
                <select id="statusFilter" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="baru">Baru</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>
                <input type="date" id="tanggalFilter" class="form-control">
                <button id="filterBtn" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
            @auth
            <div class="export-group">
                <a href="{{ route('laporan.exportCSV') }}" class="btn btn-success">
                    <i class="fas fa-file-csv"></i> Export CSV
                </a>
            </div>
            @endauth
        </div>

        <div id="laporanContainer">
            @include('laporan.partials.list', ['laporan' => $laporan])
        </div>

        <div id="paginationContainer">
            {{ $laporan->links() }}
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
let filterTimeout;

function filterLaporan() {
    const search = document.getElementById('searchInput').value;
    const jenis = document.getElementById('jenisFilter').value;
    const status = document.getElementById('statusFilter').value;
    const tanggal = document.getElementById('tanggalFilter').value;
    
    const url = new URL('{{ route("laporan.index") }}');
    if (search) url.searchParams.append('search', search);
    if (jenis) url.searchParams.append('jenis', jenis);
    if (status) url.searchParams.append('status', status);
    if (tanggal) url.searchParams.append('tanggal', tanggal);
    
    fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('laporanContainer').innerHTML = data.html;
        document.getElementById('paginationContainer').innerHTML = data.pagination;
    })
    .catch(err => console.error(err));
}

document.getElementById('searchInput').addEventListener('input', () => {
    clearTimeout(filterTimeout);
    filterTimeout = setTimeout(filterLaporan, 500);
});

['jenisFilter', 'statusFilter', 'tanggalFilter'].forEach(id => {
    document.getElementById(id).addEventListener('change', filterLaporan);
});

document.getElementById('filterBtn').addEventListener('click', filterLaporan);
function filterLaporan() {
    document.getElementById('laporanContainer').innerHTML = '<div class="text-center py-8">Loading...</div>';
    // ... rest of code
}
</script>
@endpush