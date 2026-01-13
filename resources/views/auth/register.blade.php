@extends('layouts.app')

@section('title', 'Daftar - SiBantu')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8"
        x-data="{ role: 'donatur' }">
        <div
            class="max-w-md w-full space-y-8 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                    Buat Akun Baru
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Bergabunglah dengan ribuan orang baik lainnya
                </p>
            </div>

            @if ($errors->any())
                <div
                    class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 text-sm text-red-600 dark:text-red-400">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Saya ingin mendaftar
                        sebagai:</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative border rounded-xl p-4 cursor-pointer transition-all"
                            :class="role === 'donatur' ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:border-blue-500' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50'">
                            <input type="radio" name="role" value="donatur" class="sr-only" x-model="role">
                            <div class="text-center">
                                <i class="fas fa-heart text-2xl mb-2"
                                    :class="role === 'donatur' ? 'text-blue-600' : 'text-gray-400'"></i>
                                <div class="font-bold text-sm"
                                    :class="role === 'donatur' ? 'text-blue-900 dark:text-blue-300' : 'text-gray-900 dark:text-gray-300'">
                                    Donatur</div>
                                <div class="text-xs text-gray-500 mt-1">Ingin berdonasi</div>
                            </div>
                        </label>

                        <label class="relative border rounded-xl p-4 cursor-pointer transition-all"
                            :class="role === 'fundraiser' ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:border-blue-500' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50'">
                            <input type="radio" name="role" value="fundraiser" class="sr-only" x-model="role">
                            <div class="text-center">
                                <i class="fas fa-hand-holding-heart text-2xl mb-2"
                                    :class="role === 'fundraiser' ? 'text-blue-600' : 'text-gray-400'"></i>
                                <div class="font-bold text-sm"
                                    :class="role === 'fundraiser' ? 'text-blue-900 dark:text-blue-300' : 'text-gray-900 dark:text-gray-300'">
                                    Penggalang Dana</div>
                                <div class="text-xs text-gray-500 mt-1">Ingin cari bantuan</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                            Lengkap</label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input id="name" name="name" type="text" required
                                class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Nama Lengkap Anda">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email
                            Address</label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="nama@email.com">
                        </div>
                    </div>

                    <div>
                        <label for="password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" name="password" type="password" required
                                class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Minimal 8 karakter">
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password</label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Ulangi password">
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-lg shadow-blue-500/30">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-user-plus text-blue-500 group-hover:text-blue-400"></i>
                        </span>
                        Daftar Sekarang
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Masuk disini
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection