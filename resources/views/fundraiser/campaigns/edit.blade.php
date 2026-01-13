@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Galang Dana</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('fundraiser.campaigns.update', $campaign->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Judul Campaign</label>
                    <input type="text" name="title" value="{{ old('title', $campaign->title) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Target Donasi (Rp)</label>
                    <input type="number" name="target_amount" value="{{ old('target_amount', $campaign->target_amount) }}"
                        min="100000"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Batas Waktu (Deadline)</label>
                    <input type="date" name="deadline"
                        value="{{ old('deadline', \Carbon\Carbon::parse($campaign->deadline)->format('Y-m-d')) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Foto Cover (Opsional)</label>
                    @if($campaign->image_url)
                        <img src="{{ asset('storage/' . $campaign->image_url) }}" class="h-32 object-cover rounded mb-2">
                    @endif
                    <input type="file" name="image" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto.</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Lengkap</label>
                    <textarea name="description" rows="5"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>{{ old('description', $campaign->description) }}</textarea>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('fundraiser.dashboard') }}" class="text-gray-500 hover:text-gray-700">Batal</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Campaign
                    </button>
                </div>
            </form>
        </div>

        <!-- Updates Section -->
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6 mt-8">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Kabar Terbaru (Updates)</h3>

            <!-- List Updates -->
            <div class="mb-6 space-y-4">
                @foreach($campaign->updates as $update)
                    <div class="border-b pb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-bold text-md">{{ $update->title }}</h4>
                                <p class="text-xs text-gray-500">{{ $update->created_at->format('d M Y') }}</p>
                                <p class="text-gray-700 mt-1">{{ Str::limit($update->content, 100) }}</p>
                            </div>
                            <form action="{{ route('fundraiser.campaigns.updates.destroy', $update->id) }}" method="POST"
                                onsubmit="return confirm('Hapus kabar ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
                @if($campaign->updates->isEmpty())
                    <p class="text-gray-500 italic">Belum ada kabar terbaru.</p>
                @endif
            </div>

            <!-- Add Update Form -->
            <form action="{{ route('fundraiser.campaigns.updates.store', $campaign->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Judul Kabar</label>
                    <input type="text" name="title"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required placeholder="Contoh: Dana telah disalurkan...">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Isi Kabar</label>
                    <textarea name="content" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required placeholder="Ceritakan perkembangan terbaru..."></textarea>
                </div>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Posting Kabar
                </button>
            </form>
        </div>
@endsection