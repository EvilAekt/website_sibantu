{{-- resources/views/laporan/partials/list.blade.php --}}
<div class="laporan-grid">
    @forelse($laporan as $item)
    <div class="laporan-card">
        @if($item->foto)
        <div class="laporan-image">
            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_pelapor }}">
        </div>
        @endif
        <div class="laporan-content">
            <div class "laporan-header">
                <h3>{{ $item->nama_pelapor }}</h3>
                <span class="badge 
                    @if($item->status === 'baru') bg-yellow-100 text-yellow-800
                    @elseif($item->status === 'diproses') bg-blue-100 text-blue-800
                    @else bg-green-100 text-green-800
                    @endif
                    px-2 py-1 rounded-full text-sm font-medium">
                    {{ ucfirst($item->status) }}
                </span>
            </div>
            <p class="laporan-location">
                <i class="fas fa-map-marker-alt text-gray-500 mr-1"></i> {{ $item->lokasi }}
            </p>
            <p class="laporan-desc text-gray-700">{{ Str::limit($item->deskripsi, 100) }}</p>
            <div class="laporan-meta flex justify-between items-center mt-3">
                <span class="badge 
                    @if($item->jenis_bantuan === 'pangan') bg-red-100 text-red-800
                    @elseif($item->jenis_bantuan === 'kesehatan') bg-green-100 text-green-800
                    @elseif($item->jenis_bantuan === 'pendidikan') bg-blue-100 text-blue-800
                    @else bg-purple-100 text-purple-800
                    @endif
                    px-2 py-1 rounded text-xs font-medium">
                    {{ ucfirst($item->jenis_bantuan) }}
                </span>
                <span class="text-sm text-gray-500">
                    <i class="fas fa-calendar mr-1"></i> {{ $item->created_at->format('d M Y') }}
                </span>
            </div>

            @auth
            <div class="laporan-actions mt-4 flex space-x-2">
                <a href="{{ route('laporan.show', $item->id) }}" class="btn btn-sm btn-primary flex items-center">
                    <i class="fas fa-eye mr-1"></i> Detail
                </a>
                @if($item->status !== 'selesai')
                <select class="status-select border rounded px-2 py-1 text-sm" data-id="{{ $item->id }}">
                    <option value="baru" {{ $item->status === 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="diproses" {{ $item->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ $item->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @endif
            </div>
            @endauth
        </div>
    </div>
    @empty
    <div class="empty-state text-center py-12 w-full">
        <div class="text-5xl text-gray-300 mb-4">
            <i class="fas fa-inbox"></i>
        </div>
        <p class="text-gray-500">Belum ada laporan bantuan.</p>
        <a href="{{ route('laporan.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Laporkan Sekarang
        </a>
    </div>
    @endforelse
</div>

@auth
@push('scripts')
<script>
document.querySelectorAll('.status-select').forEach(select => {
    select.addEventListener('change', function() {
        const id = this.dataset.id;
        const status = this.value;
        
        fetch(`/laporan/${id}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Animasi feedback
                const badge = this.closest('.laporan-card').querySelector('.badge');
                if (badge) {
                    badge.textContent = data.data.status.charAt(0).toUpperCase() + data.data.status.slice(1);
                    // Update warna sesuai status
                    badge.className = 'badge px-2 py-1 rounded-full text-sm font-medium ' +
                        (data.data.status === 'baru' ? 'bg-yellow-100 text-yellow-800' :
                         data.data.status === 'diproses' ? 'bg-blue-100 text-blue-800' :
                         'bg-green-100 text-green-800');
                }
                showAlert('success', data.message);
            }
        })
        .catch(() => showAlert('error', 'Gagal mengupdate status.'));
    });
});

function showAlert(type, message) {
    // Hapus alert lama
    document.querySelectorAll('.custom-alert').forEach(el => el.remove());
    
    const alert = document.createElement('div');
    alert.className = `custom-alert fixed top-4 right-4 px-4 py-2 rounded shadow-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    alert.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i> ${message}`;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.classList.add('opacity-0', 'transition-opacity');
        setTimeout(() => alert.remove(), 300);
    }, 3000);
}
</script>
@endpush
@endauth

<style>
.laporan-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}
.laporan-card {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    overflow: hidden;
    background: white;
    transition: transform 0.2s, box-shadow 0.2s;
}
.laporan-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.laporan-image img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}
.laporan-content {
    padding: 1rem;
}
.laporan-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}
</style>