@extends('layouts.app')

@section('title', 'Masuk - SiBantu')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div
            class="max-w-md w-full space-y-8 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                    Selamat Datang Kembali
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Masuk untuk mulai berdonasi atau menggalang dana
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

            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                <div class="space-y-4">
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
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                            Ingat saya
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                            Lupa password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-lg shadow-blue-500/30">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt text-blue-500 group-hover:text-blue-400"></i>
                        </span>
                        Masuk
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Daftar Sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection