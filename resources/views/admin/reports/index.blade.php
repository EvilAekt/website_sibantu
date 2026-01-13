@extends('layouts.dashboard')

@section('title', 'Kelola Laporan - SiBantu')

@section('header')
    <div class="flex justify-between items-center">
        <div class="flex flex-col">
            <h1 class="text-xl font-bold text-gray-800 dark:text-white">Laporan Bencana & Pengajuan</h1>
            <p class="text-xs text-gray-500">Kelola laporan masuk dan konversi menjadi kampanye</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        @if($reports->count() > 0)
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($reports as $report)
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition flex flex-col md:flex-row gap-6">
                        <!-- Image -->
                        <div class="w-full md:w-48 h-32 bg-gray-200 rounded-lg flex-shrink-0 bg-cover bg-center shadow-sm"
                            style="background-image: url('{{ $report->image_url ? asset('storage/' . $report->image_url) : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'150\' height=\'150\' viewBox=\'0 0 150 150\'%3E%3Crect fill=\'%23e5e7eb\' width=\'150\' height=\'150\'/%3E%3Ctext fill=\'%239ca3af\' font-family=\'sans-serif\' font-size=\'14\' dy=\'10.5\' font-weight=\'bold\' x=\'50%25\' y=\'50%25\' text-anchor=\'middle\'%3ENo Image%3C/text%3E%3C/svg%3E' }}')">
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-bold text-gray-800 dark:text-white text-lg">{{ $report->title }}</h4>
                                    <p class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                        <i class="fas fa-map-marker-alt"></i> {{ $report->location }} 
                                        <span class="mx-2">•</span> 
                                        {{ $report->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full border border-red-200 uppercase tracking-wide">
                                        {{ $report->severity }}
                                    </span>
                                    @if($report->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded">Pending Review</span>
                                    @elseif($report->status == 'approved')
                                        <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-0.5 rounded">Converted</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-[10px] font-bold px-2 py-0.5 rounded">Rejected</span>
                                    @endif
                                </div>
                            </div>
                            
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                                {{ $report->description }}
                            </p>
                            
                            <!-- Actions -->
                            @if($report->status == 'pending')
                                <div class="flex gap-3">
                                    <button onclick="openModal('convertModal{{ $report->id }}')"
                                        class="bg-blue-600 text-white text-sm font-bold px-4 py-2 rounded-lg hover:bg-blue-700 shadow-md transition transform hover:scale-105">
                                        <i class="fas fa-magic mr-1"></i> Konversi ke Kampanye
                                    </button>
                                    <form action="{{ route('admin.report.reject', $report->id) }}" method="POST">
                                        @csrf
                                        <button class="bg-white border border-red-200 text-red-600 hover:bg-red-50 text-sm px-4 py-2 rounded-lg font-bold transition">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Convert Modal -->
                    <div id="convertModal{{ $report->id }}" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4 transition-opacity duration-300">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-lg shadow-2xl transform scale-100 transition-all p-6 relative">
                            <button onclick="closeModal('convertModal{{ $report->id }}')" class="absolute right-4 top-4 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                            
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Konversi Laporan</h3>
                                <p class="text-sm text-gray-500">Ubah laporan ini menjadi kampanye penggalangan dana publik.</p>
                            </div>

                            <form action="{{ route('admin.report.convert', $report->id) }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Judul Kampanye</label>
                                        <input type="text" name="title" value="{{ $report->title }}"
                                            class="w-full rounded-lg border-gray-300 dark:bg-gray-700 text-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Target Dana (Rp)</label>
                                            <input type="number" name="target_amount" required min="100000" placeholder="Rp 0"
                                                class="w-full rounded-lg border-gray-300 dark:bg-gray-700 text-sm focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Deadline</label>
                                            <input type="date" name="deadline" required
                                                class="w-full rounded-lg border-gray-300 dark:bg-gray-700 text-sm focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-8 flex justify-end gap-3">
                                    <button type="button" onclick="closeModal('convertModal{{ $report->id }}')"
                                        class="px-4 py-2 text-gray-500 hover:text-gray-700 font-medium text-sm">Batal</button>
                                    <button type="submit"
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold text-sm hover:bg-blue-700 shadow-lg">
                                        Publikasikan Kampanye
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                {{ $reports->links() }}
            </div>
        @else
            <div class="p-16 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-700 mb-6">
                    <i class="fas fa-folder-open text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tidak Ada Laporan</h3>
                <p class="text-gray-500 text-sm mt-1">Belum ada laporan bencana yang masuk saat ini.</p>
            </div>
        @endif
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
