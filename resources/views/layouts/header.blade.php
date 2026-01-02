<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiBantu - Sistem Pelaporan Bantuan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">

    <nav class="bg-blue-800 text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-xl font-bold">
                SiBantu
            </a>

            <div class="space-x-4">
                <a href="/" class="hover:underline">Beranda</a>
                <a href="/tentang" class="hover:underline">Tentang</a>

                @auth
                    <span class="mx-2">
                        Halo, {{ auth()->user()->name }}
                    </span>

                    <a href="{{ route('logout') }}"
                       class="hover:underline"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Keluar
                    </a>

                    <form id="logout-form"
                          action="{{ route('logout') }}"
                          method="POST"
                          class="hidden">
                        @csrf
                    </form>
                @else
                    <a href="/login" class="hover:underline">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto mt-6 px-4 flex-grow">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
    <footer class="bg-gray-800 text-white text-center py-4 mt-12">
        <p>
            &copy; {{ date('Y') }} SiBantu. Sistem Pelaporan & Penyaluran Bantuan Masyarakat.
        </p>
    </footer>

</body>
</html>
