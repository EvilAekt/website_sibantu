@extends('layouts.dashboard')

@section('title', 'Pengaturan Profil - SiBantu')

@section('header')
    <div class="flex flex-col">
        <h1 class="text-xl font-bold text-gray-800 dark:text-white">Pengaturan Akun</h1>
        <p class="text-xs text-gray-500">Kelola informasi profil dan keamanan akun Anda</p>
    </div>
@endsection

@section('content')
    <div class="space-y-6">
        <div
            class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div
            class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div
            class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection