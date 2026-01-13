@extends('layouts.app')

@section('title', 'Lapor Bencana - SiBantu')

@section('content')
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-12" x-data="reportForm()">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="bg-red-600 px-8 py-6 text-center">
                        <h1 class="text-2xl font-bold text-white mb-2">Form Laporan Bencana</h1>
                        <p class="text-red-100">Segera laporkan kejadian bencana untuk mendapatkan bantuan</p>
                    </div>

                    <div class="p-8">
                        @if ($errors->any())
                            <div
                                class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-6">
                                <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Title -->
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Judul
                                    Laporan</label>
                                <input type="text" name="title" value="{{ old('title') }}" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-red-500 focus:border-red-500"
                                    placeholder="Contoh: Banjir Bandang di Desa Sukamaju">
                            </div>

                            <!-- Category & Severity -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Kategori
                                        Bencana</label>
                                    <select name="category" required
                                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-red-500 focus:border-red-500">
                                        <option value="" disabled selected>Pilih Kategori</option>
                                        <option value="bencana" {{ old('category') == 'bencana' ? 'selected' : '' }}>Bencana
                                            Alam</option>
                                        <option value="kesehatan" {{ old('category') == 'kesehatan' ? 'selected' : '' }}>
                                            Kesehatan (Wabah)</option>
                                        <option value="infrastruktur" {{ old('category') == 'infrastruktur' ? 'selected' : '' }}>Kerusakan Infrastruktur</option>
                                        <option value="sosial" {{ old('category') == 'sosial' ? 'selected' : '' }}>Konflik
                                            Sosial</option>
                                        <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>Lainnya
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Tingkat
                                        Keparahan</label>
                                    <select name="severity" required
                                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-red-500 focus:border-red-500">
                                        <option value="" disabled selected>Pilih Tingkat</option>
                                        <option value="ringan" {{ old('severity') == 'ringan' ? 'selected' : '' }}>Ringan
                                            (Dampak Minim)</option>
                                        <option value="sedang" {{ old('severity') == 'sedang' ? 'selected' : '' }}>Sedang
                                            (Perlu Bantuan)</option>
                                        <option value="berat" {{ old('severity') == 'berat' ? 'selected' : '' }}>Berat
                                            (Kerusakan Luas)</option>
                                        <option value="darurat" {{ old('severity') == 'darurat' ? 'selected' : '' }}>Darurat
                                            (Evakuasi Segera)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Lokasi
                                    Kejadian</label>
                                <div class="relative">
                                    <input type="text" name="location" x-model="location" required
                                        class="w-full pl-4 pr-12 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-red-500 focus:border-red-500 py-2.5"
                                        placeholder="Alamat lengkap atau koordinat lokasi...">
                                    <button type="button" @click="getLocation" title="Gunakan Lokasi Saat Ini"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-gray-500 hover:text-red-600 transition">
                                        <i class="fas fa-map-marker-alt"
                                            :class="loadingLocation ? 'animate-bounce' : ''"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1" x-text="locationStatus"></p>
                            </div>

                            <!-- Image -->
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Foto
                                    Bukti</label>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-red-500 transition cursor-pointer bg-gray-50 dark:bg-gray-700/50"
                                    @click="$refs.imageInput.click()">
                                    <input type="file" name="image_url" accept="image/*" x-ref="imageInput"
                                        @change="previewImage" class="hidden" required>
                                    <div x-show="!imagePreview">
                                        <i class="fas fa-camera text-4xl text-gray-400 mb-3"></i>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Klik untuk upload foto kejadian
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">Maksimal 2MB (JPG, PNG)</p>
                                    </div>
                                    <div x-show="imagePreview" class="relative">
                                        <img :src="imagePreview" class="max-h-64 mx-auto rounded-lg shadow-sm">
                                        <button type="button" @click.stop="removeImage"
                                            class="absolute top-2 right-2 w-8 h-8 bg-red-500 text-white rounded-full hover:bg-red-600 shadow-md flex items-center justify-center">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-8">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Kronologi /
                                    Deskripsi</label>
                                <textarea name="description" rows="5" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-red-500 focus:border-red-500"
                                    placeholder="Jelaskan secara rinci apa yang terjadi, kebutuhan mendesak, dan jumlah korban (jika ada)...">{{ old('description') }}</textarea>
                            </div>

                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('laporan.index') }}"
                                    class="px-6 py-2.5 text-gray-600 dark:text-gray-300 font-medium hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-red-500/30 transition transform hover:-translate-y-1">
                                    <i class="fas fa-paper-plane mr-2"></i> Kirim Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function reportForm() {
            return {
                location: '{{ old("location") }}',
                locationStatus: '',
                loadingLocation: false,
                imagePreview: null,

                getLocation() {
                    if (!navigator.geolocation) {
                        this.locationStatus = 'Geolocation tidak didukung browser Anda.';
                        return;
                    }

                    this.loadingLocation = true;
                    this.locationStatus = 'Mengambil lokasi...';

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            // Simple reverse geocoding via OpenStreetMap Nominatim (optional, or just submit coords)
                            // For now, let's just put coords, but user can edit. 
                            // Better to fetch address if possible, but avoiding external API dep complexity for now.
                            // Just put coords is simplest.
                            this.location = `Lat: ${lat}, Lng: ${lng}`;
                            this.locationStatus = 'Lokasi ditemukan (Koordinat GPS)';
                            this.loadingLocation = false;

                            // Optional: Try to fetch address
                            // fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                            //    .then(response => response.json())
                            //    .then(data => {
                            //         if(data.display_name) this.location = data.display_name;
                            //    });
                        },
                        (error) => {
                            this.locationStatus = 'Gagal mengambil lokasi: ' + error.message;
                            this.loadingLocation = false;
                        }
                    );
                },

                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.imagePreview = URL.createObjectURL(file);
                    }
                },

                removeImage() {
                    this.imagePreview = null;
                    this.$refs.imageInput.value = '';
                }
            }
        }
    </script>
@endsection