@extends('layouts.dashboard')

@section('title', 'Buat Kampanye - SiBantu')

@section('breadcrumb')
    <span class="text-gray-700 dark:text-gray-300">Buat Kampanye Baru</span>
@endsection

@section('content')
    <div class="max-w-3xl mx-auto" x-data="campaignForm()">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 dark:text-white">Buat Kampanye Baru</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Isi formulir di bawah untuk membuat kampanye penggalangan dana
            </p>
        </div>

        <!-- Progress Steps -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-8">
            <div class="flex items-center justify-between">
                <template x-for="(stepItem, index) in steps" :key="index">
                    <div class="flex items-center" :class="index < steps.length - 1 ? 'flex-1' : ''">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all"
                                :class="step > index + 1 ? 'bg-green-500 text-white' : (step === index + 1 ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500')">
                                <span x-show="step <= index + 1" x-text="index + 1"></span>
                                <i x-show="step > index + 1" class="fas fa-check"></i>
                            </div>
                            <span class="text-xs mt-2 text-center hidden sm:block"
                                :class="step === index + 1 ? 'text-blue-600 font-medium' : 'text-gray-500'"
                                x-text="stepItem"></span>
                        </div>
                        <div x-show="index < steps.length - 1"
                            class="flex-1 h-1 mx-2 rounded-full bg-gray-200 dark:bg-gray-700">
                            <div class="h-1 rounded-full bg-blue-600 transition-all duration-300"
                                :style="'width: ' + (step > index + 1 ? '100%' : '0%')"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('fundraiser.campaigns.store') }}" method="POST" enctype="multipart/form-data"
            @submit="validateStep">
            @csrf

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-6">
                        <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Step 1: Informasi Dasar -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Informasi Dasar</h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Kampanye
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="title" x-model="formData.title" required
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: Bantu Korban Banjir Bandung">
                            <p class="text-xs text-gray-500 mt-1">Buat judul yang jelas dan menarik perhatian</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                            <select name="category" x-model="formData.category"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="bencana">Bencana Alam</option>
                                <option value="kesehatan">Kesehatan</option>
                                <option value="pendidikan">Pendidikan</option>
                                <option value="sosial">Sosial</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Target & Durasi -->
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Target & Durasi</h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Target Donasi
                                <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" name="target_amount" x-model="formData.target_amount" required
                                    min="100000"
                                    class="w-full pl-12 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="10000000">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Minimal Rp 100.000</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Batas Waktu <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="deadline" x-model="formData.deadline" required
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                                :min="minDate">
                            <p class="text-xs text-gray-500 mt-1">Kampanye akan berakhir pada tanggal ini</p>
                        </div>

                        <div
                            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                <div>
                                    <p class="text-sm text-blue-700 dark:text-blue-300 font-medium">Tips Menentukan Target
                                    </p>
                                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">Tentukan target yang realistis
                                        berdasarkan kebutuhan. Target yang terlalu tinggi bisa membuat donatur ragu.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Deskripsi & Gambar -->
                <div x-show="step === 3" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Deskripsi & Gambar</h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto Cover <span
                                    class="text-red-500">*</span></label>
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-blue-500 transition cursor-pointer"
                                @click="$refs.imageInput.click()">
                                <input type="file" name="image" accept="image/*" x-ref="imageInput" @change="previewImage"
                                    class="hidden" required>
                                <div x-show="!imagePreview">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Klik untuk upload gambar</p>
                                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF (Max 2MB)</p>
                                </div>
                                <div x-show="imagePreview" class="relative">
                                    <img :src="imagePreview" class="max-h-48 mx-auto rounded-lg">
                                    <button type="button" @click.stop="removeImage"
                                        class="absolute top-2 right-2 w-8 h-8 bg-red-500 text-white rounded-full hover:bg-red-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi Lengkap
                                <span class="text-red-500">*</span></label>
                            <textarea name="description" x-model="formData.description" rows="6" required
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Ceritakan secara detail tentang kampanye ini, siapa yang dibantu, untuk apa dana akan digunakan, dll."></textarea>
                            <p class="text-xs text-gray-500 mt-1">Minimal 100 karakter</p>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Review -->
                <div x-show="step === 4" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Review & Submit</h3>

                    <div class="space-y-6">
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <h4 class="font-medium text-gray-800 dark:text-white mb-4">Ringkasan Kampanye</h4>

                            <div class="space-y-3">
                                <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-600">
                                    <span class="text-gray-500">Judul</span>
                                    <span class="font-medium text-gray-800 dark:text-white"
                                        x-text="formData.title || '-'"></span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-600">
                                    <span class="text-gray-500">Target</span>
                                    <span class="font-medium text-gray-800 dark:text-white"
                                        x-text="'Rp ' + formatNumber(formData.target_amount)"></span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-600">
                                    <span class="text-gray-500">Deadline</span>
                                    <span class="font-medium text-gray-800 dark:text-white"
                                        x-text="formData.deadline || '-'"></span>
                                </div>
                                <div class="pt-2">
                                    <span class="text-gray-500 block mb-2">Deskripsi</span>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-lg p-3"
                                        x-text="formData.description || '-'"></p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-0.5"></i>
                                <div>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300 font-medium">Perhatian</p>
                                    <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">
                                        @if(!auth()->user()->is_verified)
                                            Akun Anda belum terverifikasi. Kampanye akan menunggu persetujuan admin.
                                        @else
                                            Kampanye akan langsung aktif setelah dikirim.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" x-model="agreed"
                                class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Saya menyetujui syarat dan ketentuan
                                SiBantu</span>
                        </label>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" @click="prevStep" x-show="step > 1"
                        class="px-6 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl font-medium transition">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </button>
                    <div x-show="step === 1"></div>

                    <button type="button" @click="nextStep" x-show="step < 4"
                        class="px-6 py-2 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                        Lanjut <i class="fas fa-arrow-right ml-2"></i>
                    </button>

                    <button type="submit" x-show="step === 4" :disabled="!agreed"
                        class="px-6 py-2 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim Kampanye
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function campaignForm() {
                return {
                    step: 1,
                    steps: ['Informasi', 'Target', 'Deskripsi', 'Review'],
                    formData: {
                        title: '{{ old('title') }}',
                        category: '{{ old('category', 'bencana') }}',
                        target_amount: '{{ old('target_amount') }}',
                        deadline: '{{ old('deadline') }}',
                        description: '{{ old('description') }}'
                    },
                    imagePreview: null,
                    agreed: false,
                    minDate: new Date().toISOString().split('T')[0],

                    nextStep() {
                        if (this.validateCurrentStep()) {
                            this.step++;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                    },

                    prevStep() {
                        this.step--;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    },

                    validateCurrentStep() {
                        if (this.step === 1) {
                            if (!this.formData.title) {
                                alert('Judul kampanye wajib diisi');
                                return false;
                            }
                        }
                        if (this.step === 2) {
                            if (!this.formData.target_amount || this.formData.target_amount < 100000) {
                                alert('Target donasi minimal Rp 100.000');
                                return false;
                            }
                            if (!this.formData.deadline) {
                                alert('Batas waktu wajib diisi');
                                return false;
                            }
                        }
                        if (this.step === 3) {
                            if (!this.formData.description || this.formData.description.length < 100) {
                                alert('Deskripsi minimal 100 karakter');
                                return false;
                            }
                        }
                        return true;
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
                    },

                    formatNumber(num) {
                        if (!num) return '0';
                        return new Intl.NumberFormat('id-ID').format(num);
                    }
                }
            }
        </script>
    @endpush
@endsection