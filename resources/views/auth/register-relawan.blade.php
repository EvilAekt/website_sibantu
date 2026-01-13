<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Relawan - SiBantu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Relawan</h1>
            <p class="text-gray-600">Bergabunglah untuk membantu sesama</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.relawan') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 mb-2">Kata Sandi</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div>
            <div class="mb-6">
                <label for="ktp" class="block text-gray-700 mb-2">Upload KTP (Foto/Scan)</label>
                <input type="file" id="ktp" name="ktp" accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                Daftar Sebagai Relawan
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 font-medium">Masuk di sini</a>
            </p>
        </div>
    </div>
</body>

</html>