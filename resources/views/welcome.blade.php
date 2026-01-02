<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiBantu - Bantuan Masyarakat</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .hero-bg {
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 50%, #3b82f6 100%);
            color: white;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background: #1d4ed8;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: #1e40af;
            transform: scale(1.05);
        }
        .btn-secondary {
            background: #f3f4f6;
            color: #1f2937;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: #e5e7eb;
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Hero Section -->
    <section class="hero-bg py-16 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9M5 21v-7m8 0v7M5 21a2 2 0 01-2-2v-7a2 2 0 012-2h6a2 2 0 012 2v7a2 2 0 01-2 2H5z" />
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Selamat Datang di SiBantu</h1>
            <p class="text-xl max-w-2xl mx-auto opacity-90">
                Platform pelaporan dan penyaluran bantuan untuk masyarakat yang membutuhkan.
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16 px-4">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg p-8 card-hover">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Mulai Sekarang</h2>
                <p class="text-gray-600 mt-2">Pilih aksi yang ingin Anda lakukan</p>
            </div>

            <div class="space-y-4">
                <a href="{{ route('login') }}" class="block btn-primary text-center">
                    <i class="fas fa-sign-in-alt mr-2"></i> Masuk ke Akun
                </a>
                <a href="{{ route('register.relawan') }}" class="block btn-secondary text-center">
                    <i class="fas fa-user-plus mr-2"></i> Daftar Sebagai Relawan
                </a>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Belum punya akun? <a href="{{ route('register.relawan') }}" class="text-blue-600 hover:underline">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 text-center">
        <div class="container mx-auto px-4">
            <p>&copy; {{ date('Y') }} SiBantu. S