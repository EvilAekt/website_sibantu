@extends('layouts.app')

@section('title', 'Donasi - ' . $campaign->title)

@section('content')
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-12" x-data="donationForm()">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-8">
                    <p class="text-gray-500 dark:text-gray-400 mb-2">Anda akan berdonasi untuk:</p>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $campaign->title }}</h1>
                </div>

                <!-- Steps -->
                <div class="flex items-center justify-between mb-8 px-8">
                    <template x-for="(label, index) in steps" :key="index">
                        <div class="flex flex-col items-center relative z-10">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-300"
                                :class="step > index ? 'bg-green-500 text-white' : (step === index + 1 ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-200 dark:bg-gray-700 text-gray-500')">
                                <span x-show="step <= index + 1" x-text="index + 1"></span>
                                <i x-show="step > index + 1" class="fas fa-check"></i>
                            </div>
                            <span class="text-xs mt-2 font-medium"
                                :class="step === index + 1 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500'"
                                x-text="label"></span>
                        </div>
                    </template>
                    <!-- Line -->
                    <div
                        class="absolute w-full max-w-lg h-0.5 bg-gray-200 dark:bg-gray-700 top-16 left-1/2 -translate-x-1/2 -z-0">
                        <div class="h-full bg-green-500 transition-all duration-300"
                            :style="'width: ' + ((step - 1) / (steps.length - 1) * 100) + '%'"></div>
                    </div>
                </div>

                <form action="{{ route('campaigns.storeDonation', $campaign->slug) }}" method="POST" @submit="validateForm">
                    @csrf
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 md:p-8">

                        <!-- Step 1: Nominal -->
                        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Pilih Nominal Donasi</h2>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                                <template x-for="amount in presets" :key="amount">
                                    <button type="button" @click="selectAmount(amount)"
                                        class="py-3 px-4 rounded-xl border text-sm font-semibold transition-all duration-200"
                                        :class="selectedAmount === amount ? 'border-blue-600 bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:border-blue-500 dark:text-blue-400' : 'border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-700 text-gray-600 dark:text-gray-300'">
                                        Rp <span x-text="formatNumber(amount)"></span>
                                    </button>
                                </template>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nominal
                                    Lainnya</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                    <input type="number" name="amount" x-model="customAmount" @input="selectedAmount = null"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 text-lg font-semibold"
                                        placeholder="Masukan nominal..." min="10000">
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Minimal donasi Rp 10.000</p>
                            </div>

                            <button type="button" @click="nextStep" :disabled="!isValidAmount"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg transition transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                                Lanjut Pembayaran
                            </button>
                        </div>

                        <!-- Step 2: Metode Pembayaran -->
                        <div x-show="step === 2" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Pilih Metode Pembayaran</h2>

                            <div class="space-y-3 mb-8">
                                <label class="flex items-center p-4 border rounded-xl cursor-pointer transition-colors"
                                    :class="paymentMethod === 'qris' ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:border-blue-500' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50'">
                                    <input type="radio" name="payment_method" value="qris" x-model="paymentMethod"
                                        class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-4 flex-1">
                                        <span class="block font-semibold text-gray-800 dark:text-white">QRIS (GoPay, OVO,
                                            Dana)</span>
                                        <span class="block text-sm text-gray-500">Scan QR code instan</span>
                                    </div>
                                    <i class="fas fa-qrcode text-2xl text-gray-400"></i>
                                </label>

                                <label class="flex items-center p-4 border rounded-xl cursor-pointer transition-colors"
                                    :class="paymentMethod === 'bank_transfer' ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:border-blue-500' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50'">
                                    <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod"
                                        class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-4 flex-1">
                                        <span class="block font-semibold text-gray-800 dark:text-white">Transfer Bank</span>
                                        <span class="block text-sm text-gray-500">BCA, Mandiri, BRI, BNI</span>
                                    </div>
                                    <i class="fas fa-university text-2xl text-gray-400"></i>
                                </label>

                                <label class="flex items-center p-4 border rounded-xl cursor-pointer transition-colors"
                                    :class="paymentMethod === 'ewallet' ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:border-blue-500' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50'">
                                    <input type="radio" name="payment_method" value="ewallet" x-model="paymentMethod"
                                        class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-4 flex-1">
                                        <span class="block font-semibold text-gray-800 dark:text-white">E-Wallet</span>
                                        <span class="block text-sm text-gray-500">LinkAja, ShopeePay</span>
                                    </div>
                                    <i class="fas fa-wallet text-2xl text-gray-400"></i>
                                </label>
                            </div>

                            <div class="flex gap-4">
                                <button type="button" @click="step = 1"
                                    class="w-1/3 border border-gray-300 text-gray-700 dark:text-gray-300 font-semibold py-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    Kembali
                                </button>
                                <button type="button" @click="nextStep" :disabled="!paymentMethod"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg transition transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Lanjut
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Konfirmasi -->
                        <div x-show="step === 3" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Konfirmasi Donasi</h2>

                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-6">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-gray-500 dark:text-gray-400">Nominal Donasi</span>
                                    <span class="text-xl font-bold text-blue-600">Rp <span
                                            x-text="formatNumber(finalAmount)"></span></span>
                                </div>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-gray-500 dark:text-gray-400">Biaya Admin</span>
                                    <span class="text-sm font-semibold text-gray-800 dark:text-white">Rp 0 (Gratis)</span>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-600 my-4"></div>
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-gray-800 dark:text-white">Total Pembayaran</span>
                                    <span class="text-2xl font-bold text-gray-800 dark:text-white">Rp <span
                                            x-text="formatNumber(finalAmount)"></span></span>
                                </div>
                            </div>

                            <div
                                class="mb-6 p-4 border border-blue-100 bg-blue-50 dark:bg-blue-900/20 dark:border-blue-800 rounded-xl flex gap-3">
                                <i class="fas fa-shield-alt text-blue-600 mt-1"></i>
                                <div>
                                    <p class="text-sm font-semibold text-blue-800 dark:text-blue-200">Pembayaran Aman</p>
                                    <p class="text-xs text-blue-600 dark:text-blue-300">Donasi Anda akan langsung disalurkan
                                        ke rekening resmi SiBantu.</p>
                                </div>
                            </div>

                            <!-- Hidden Inputs -->
                            <input type="hidden" name="amount" :value="finalAmount">

                            <div class="flex gap-4">
                                <button type="button" @click="step = 2"
                                    class="w-1/3 border border-gray-300 text-gray-700 dark:text-gray-300 font-semibold py-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    Kembali
                                </button>
                                <button type="submit"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl shadow-lg transition transform active:scale-95">
                                    Bayar Sekarang
                                </button>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function donationForm() {
            return {
                step: 1,
                steps: ['Nominal', 'Metode', 'Konfirmasi'],
                presets: [10000, 25000, 50000, 100000, 250000, 500000],
                selectedAmount: null,
                customAmount: '',
                paymentMethod: null,

                get finalAmount() {
                    return this.selectedAmount || this.customAmount;
                },

                get isValidAmount() {
                    return this.finalAmount >= 10000;
                },

                selectAmount(amount) {
                    this.selectedAmount = amount;
                    this.customAmount = '';
                },

                nextStep() {
                    this.step++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                formatNumber(num) {
                    if (!num) return '0';
                    return new Intl.NumberFormat('id-ID').format(num);
                },

                validateForm(e) {
                    if (!this.isValidAmount || !this.paymentMethod) {
                        e.preventDefault();
                        alert('Mohon lengkapi data donasi.');
                    }
                }
            }
        }
    </script>
@endsection