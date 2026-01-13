@extends('layouts.dashboard')

@section('title', 'Fundraiser Dashboard - SiBantu')

@section('header')
    <div class="flex flex-col">
        <h1 class="text-xl font-bold text-gray-800 dark:text-white">Fundraiser Dashboard</h1>
        <p class="text-xs text-gray-500">Kelola kampanye & donasi Anda</p>
    </div>
@endsection

@section('content')
    <div x-data="{ withdrawModalOpen: false }">
        <!-- Verification Warning -->
        @if(!auth()->user()->is_verified)
            <div
                class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-8 flex items-start gap-4 shadow-sm">
                <div class="p-2 bg-yellow-100 rounded-lg text-yellow-600">
                    <i class="fas fa-id-card"></i>
                </div>
                <div>
                    <h4 class="font-bold text-yellow-800 dark:text-yellow-200">Verifikasi Identitas Diperlukan</h4>
                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                        Untuk keamanan, fitur penarikan dana dibatasi hingga akun Anda diverifikasi oleh Admin.
                    </p>
                </div>
            </div>
        @endif

        <!-- Hero Section: Wallet & Main Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Big Wallet Card (Span 2 to capture attention) -->
            <div
                class="lg:col-span-2 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute right-0 top-0 p-8 opacity-10 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-wallet text-9xl"></i>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6 opacity-90">
                        <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                            <i class="fas fa-coins"></i>
                        </div>
                        <span class="font-medium tracking-wide text-sm uppercase">Saldo Tersedia</span>
                    </div>

                    <h2 class="text-4xl md:text-5xl font-extrabold mb-8 tracking-tight">
                        Rp {{ number_format($walletBalance ?? 0, 0, ',', '.') }}
                    </h2>

                    <div class="flex flex-wrap gap-4">
                        @if(!($pendingWithdrawal ?? false) && auth()->user()->is_verified)
                            <button @click="withdrawModalOpen = true"
                                class="px-6 py-3 bg-white text-blue-700 rounded-xl font-bold hover:bg-blue-50 transition shadow-lg flex items-center gap-2">
                                <i class="fas fa-download"></i> Tarik Dana
                            </button>
                        @elseif($pendingWithdrawal ?? false)
                            <button disabled
                                class="px-6 py-3 bg-white/20 text-white rounded-xl font-bold cursor-not-allowed flex items-center gap-2">
                                <i class="fas fa-clock"></i> Penarikan Diproses
                            </button>
                        @else
                            <button type="button"
                                onclick="alert('Fitur ini terkunci. Harap verifikasi akun Anda di menu Pengaturan.')"
                                class="px-6 py-3 bg-white/20 text-white rounded-xl font-bold hover:bg-white/30 transition flex items-center gap-2">
                                <i class="fas fa-lock"></i> Tarik Dana
                            </button>
                        @endif

                        <a href="{{ route('fundraiser.withdrawals') }}"
                            class="px-6 py-3 bg-blue-800/50 text-white rounded-xl font-medium hover:bg-blue-800/70 transition backdrop-blur-md">
                            Lihat Riwayat
                        </a>
                    </div>
                </div>
            </div>

            <!-- Secondary Stats -->
            <div class="space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between group hover:border-blue-200 transition">
                    <div>
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Total Terkumpul</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">Rp
                            {{ number_format($totalRaised ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between group hover:border-blue-200 transition">
                    <div>
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Total Donatur</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalDonators ?? 0 }}</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between group hover:border-blue-200 transition">
                    <div>
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Kampanye Aktif</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $activeCampaigns ?? 0 }}</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fas fa-bullhorn text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Campaigns List -->
            <div class="xl:col-span-2">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 dark:text-white text-lg">Kampanye Saya</h3>
                        <a href="{{ route('fundraiser.campaigns.create') }}"
                            class="text-sm font-bold text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition">
                            + Buat Baru
                        </a>
                    </div>
                    @if($myCampaigns->count() > 0)
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($myCampaigns as $campaign)
                                @php
                                    $percent = $campaign->target_amount > 0 ? ($campaign->collected_amount / $campaign->target_amount) * 100 : 0;
                                @endphp
                                <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-200 group">
                                    <div class="flex flex-col sm:flex-row gap-6">
                                        <div
                                            class="w-full sm:w-32 h-24 bg-gray-200 rounded-xl overflow-hidden flex-shrink-0 relative">
                                            <img src="{{ $campaign->image_url ? asset('storage/' . $campaign->image_url) : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'300\' height=\'200\' viewBox=\'0 0 300 200\'%3E%3Crect fill=\'%23e5e7eb\' width=\'300\' height=\'200\'/%3E%3Ctext fill=\'%239ca3af\' font-family=\'sans-serif\' font-size=\'18\' dy=\'10.5\' font-weight=\'bold\' x=\'50%25\' y=\'50%25\' text-anchor=\'middle\'%3ENo Image%3C/text%3E%3C/svg%3E' }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                            @if($campaign->status == 'active')
                                                <span
                                                    class="absolute top-2 right-2 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-start mb-2">
                                                <h4
                                                    class="font-bold text-gray-800 dark:text-white text-lg leading-tight hover:text-blue-600 transition truncate pr-4">
                                                    {{ $campaign->title }}
                                                </h4>
                                                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <a href="{{ route('campaigns.show', $campaign->slug) }}"
                                                        class="p-1.5 text-gray-400 hover:text-blue-600 rounded hover:bg-blue-50"
                                                        title="View"><i class="fas fa-external-link-alt"></i></a>
                                                    <a href="{{ route('fundraiser.campaigns.edit', $campaign->id) }}"
                                                        class="p-1.5 text-gray-400 hover:text-green-600 rounded hover:bg-green-50"
                                                        title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="flex justify-between text-xs font-semibold mb-1">
                                                    <span class="text-blue-600">{{ number_format($percent, 0) }}% Terkumpul</span>
                                                    <span class="text-gray-500">Target: Rp
                                                        {{ number_format($campaign->target_amount / 1000000, 1, ',', '.') }}jt</span>
                                                </div>
                                                <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                                                    <div class="bg-blue-600 h-2.5 rounded-full"
                                                        style="width: {{ min($percent, 100) }}%"></div>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="font-bold text-gray-800 dark:text-white">Rp
                                                    {{ number_format($campaign->collected_amount, 0, ',', '.') }}</span>
                                                <span class="text-gray-500 text-xs">Berakhir
                                                    {{ \Carbon\Carbon::parse($campaign->deadline)->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <div class="inline-block p-4 rounded-full bg-blue-50 text-blue-500 mb-4">
                                <i class="fas fa-bullhorn text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Belum ada Kampanye</h3>
                            <p class="text-gray-500 text-sm mb-6 max-w-xs mx-auto">Buat kampanye pertama Anda dan mulai
                                menggalang kebaikan hari ini.</p>
                            <a href="{{ route('fundraiser.campaigns.create') }}"
                                class="inline-block px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                                Buat Kampanye Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Recent Donations -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <h3 class="font-bold text-gray-800 dark:text-white text-sm">Donasi Terbaru</h3>
                    </div>
                    @if(isset($recentDonations) && $recentDonations->count() > 0)
                        <div class="max-h-80 overflow-y-auto">
                            @foreach($recentDonations as $donation)
                                <div
                                    class="p-4 border-b border-gray-50 dark:border-gray-700/50 flex items-start gap-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <div
                                        class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0 text-xs font-bold">
                                        {{ substr($donation->user->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-500 mb-0.5">Mendonasikan <span
                                                class="font-bold text-green-600">Rp
                                                {{ number_format($donation->amount, 0, ',', '.') }}</span></p>
                                        <p class="text-xs font-medium text-gray-800 dark:text-gray-200 truncate">
                                            {{ $donation->campaign->title }}
                                        </p>
                                        <p class="text-[10px] text-gray-400 mt-1">{{ $donation->created_at->diffForHumans() }} •
                                            Oleh {{ $donation->user->name ?? 'Anonim' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center text-gray-500 text-sm">Belum ada donasi masuk.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Withdraw Modal -->
        <div x-show="withdrawModalOpen"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">

            <div @click.away="withdrawModalOpen = false"
                class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-md shadow-2xl relative overflow-hidden"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white">
                    <h3 class="text-xl font-bold">Tarik Dana Kampanye</h3>
                    <p class="text-blue-100 text-sm mt-1">Transfer dana ke rekening terdaftar</p>
                    <button @click="withdrawModalOpen = false"
                        class="absolute top-4 right-4 text-white/70 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-6">
                    <form action="{{ route('fundraiser.withdraw') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Jumlah Penarikan
                                (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold">Rp</span>
                                <input type="number" name="amount" min="50000" max="{{ $walletBalance ?? 0 }}" required
                                    class="w-full pl-12 pr-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 font-bold text-lg"
                                    placeholder="0">
                            </div>
                            <div class="flex justify-between mt-2 text-xs">
                                <span class="text-gray-500">Min: Rp 50.000</span>
                                <span class="text-blue-600 font-bold cursor-pointer hover:underline"
                                    onclick="document.querySelector('input[name=amount]').value = {{ $walletBalance ?? 0 }}">
                                    Max: Rp {{ number_format($walletBalance ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl mb-6 flex gap-3 items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Dana akan ditransfer ke rekening Bank BNI **** 1234 a.n {{ auth()->user()->name }}. Proses
                                memakan waktu 1-2 hari kerja.
                            </p>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" @click="withdrawModalOpen = false"
                                class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-bold hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                                Konfirmasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection