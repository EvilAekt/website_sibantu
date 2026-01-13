@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - SiBantu')

@section('header')
    <div class="flex flex-col">
        <h1 class="text-xl font-bold text-gray-800 dark:text-white">Admin Control Center</h1>
        <p class="text-xs text-gray-500">Platform Overview & Management</p>
    </div>
@endsection

@section('content')

    <!-- Stats Overview (High Density, Small Cards) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fas fa-donate text-4xl text-blue-600"></i>
            </div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Donasi</p>
            <p class="text-xl font-bold text-gray-800 dark:text-white mt-1">Rp
                {{ number_format($totalDonations / 1000000, 1, ',', '.') }}jt+</p>
            <div class="mt-2 text-xs text-green-600 flex items-center">
                <i class="fas fa-arrow-up mr-1"></i> 12% bulan ini
            </div>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fas fa-bullhorn text-4xl text-indigo-600"></i>
            </div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Kampanye Aktif</p>
            <p class="text-xl font-bold text-gray-800 dark:text-white mt-1">{{ $activeCampaigns ?? 0 }}</p>
            <div class="mt-2 text-xs text-gray-500">
                Target: 45 kampanye
            </div>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fas fa-users text-4xl text-purple-600"></i>
            </div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total User</p>
            <p class="text-xl font-bold text-gray-800 dark:text-white mt-1">{{ $activeUsers ?? 0 }}</p>
            <div class="mt-2 text-xs text-purple-600 font-medium">
                +{{ $pendingUsers->count() }} Verifikasi Baru
            </div>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border-l-4 border-red-500 relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fas fa-exclamation-triangle text-4xl text-red-600"></i>
            </div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Action Needed</p>
            <p class="text-xl font-bold text-gray-800 dark:text-white mt-1">
                {{ $pendingReports + $pendingUsers->count() }}</p>
            <div class="mt-2 text-xs text-red-600 font-bold animate-pulse">
                Segera Proses!
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Pending Actions (2/3 width) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- User Verification Section -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div
                    class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-user-check text-blue-500"></i> Verifikasi Pengguna Baru
                    </h3>
                    @if($pendingUsers->count() > 0)
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-md">{{ $pendingUsers->count() }}
                            Pending</span>
                    @endif
                </div>

                <div class="p-0">
                    @if($pendingUsers->count() > 0)
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-3">User</th>
                                    <th class="px-6 py-3">Role Requested</th>
                                    <th class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($pendingUsers as $user)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-3 font-medium text-gray-900 dark:text-white">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600 text-xs">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-bold">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-3">
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-200">Fundraiser</span>
                                        </td>
                                        <td class="px-6 py-3 text-right">
                                            <form action="{{ route('admin.user.verify', $user->id) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                <button
                                                    class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition shadow-sm">
                                                    Verify
                                                </button>
                                            </form>
                                            <button
                                                class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-xs font-bold px-3 py-1.5 rounded-lg transition ml-2">
                                                Data
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-8 text-center text-gray-500 text-sm">
                            <i class="fas fa-check-circle text-4xl text-gray-300 mb-2 block"></i>
                            Semua pengguna telah diverifikasi.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-bolt text-yellow-400"></i> Quick Actions
                    </h3>
                </div>
                <div class="grid grid-cols-2 gap-4">
                     <a href="{{ route('admin.reports') }}" class="flex flex-col items-center justify-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition text-blue-700 gap-2 border border-blue-100">
                        <i class="fas fa-file-alt text-2xl"></i>
                        <span class="text-xs font-bold text-center">Kelola Laporan</span>
                     </a>
                     <div class="flex flex-col items-center justify-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition text-green-700 gap-2 border border-green-100 cursor-pointer">
                        <i class="fas fa-search text-2xl"></i>
                        <span class="text-xs font-bold text-center">Cari Data</span>
                     </div>
                </div>
            </div>
        </div>

        <!-- Right Column: System Health & Activity (1/3 width) -->
        <div class="space-y-6">
            <!-- System Status -->
            <div class="bg-slate-900 rounded-xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="absolute right-[-20px] top-[-20px] w-24 h-24 bg-green-500 rounded-full blur-2xl opacity-20">
                </div>
                <h3 class="font-bold text-sm uppercase tracking-wide text-slate-400 mb-4">System Health</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b border-slate-700 pb-2">
                        <span class="text-sm">Server Status</span>
                        <span class="flex items-center text-green-400 text-xs font-mono font-bold"><span
                                class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span> ONLINE</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-slate-700 pb-2">
                        <span class="text-sm">DB Load</span>
                        <span class="text-blue-400 text-xs font-mono">12%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm">Storage</span>
                        <span class="text-orange-400 text-xs font-mono">45% Used</span>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions Mini List -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-0">
                <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Donasi Terbaru</h3>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    @foreach($recentTransactions as $transaction)
                        <div
                            class="p-3 border-b border-gray-50 dark:border-gray-700/50 flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-xs">
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-800 dark:text-gray-200">
                                        {{ Str::limit($transaction->user->name ?? 'Guest', 12) }}</p>
                                    <p class="text-[10px] text-gray-400">
                                        {{ $transaction->created_at->diffForHumans(null, true) }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-green-600">+Rp
                                {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <a href="#" class="block text-center py-3 text-xs text-blue-600 font-bold hover:bg-blue-50 transition">View
                    All Log</a>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }
    </script>

@endsection