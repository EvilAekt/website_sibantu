<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - SiBantu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Masuk ke Akun</h1>
            <p class="text-gray-600">Silakan masukkan kredensial Anda</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-2">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required
                >
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 mb-2">Kata Sandi</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required
                >
            </div>
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="mr-2">
                    <label for="remember" class="text-gray-700">Ingat saya</label>
                </div>
                <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline text-sm">Lupa kata sandi?</a>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">Masuk</button>
        </form>

        <div class="text-center mt-4">
            <p class="text-gray-600">
                Belum punya akun?
                <a href="{{ route('register.relawan') }}" class="text-blue-600 font-medium">Daftar Relawan</a>
            </p>
        </div>
    </div>
</body>
</html>