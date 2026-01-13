<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'donatur', // Default role for standard registration
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }

    public function createRelawan(): View
    {
        return view('auth.register-relawan');
    }

    public function storeRelawan(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'ktp' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);


        $ktpPath = $request->file('ktp')->store('ktp', 'public');


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'fundraiser', // Map Relawan -> Fundraiser (valid DB value)
            'ktp_path' => $ktpPath,
            'is_verified' => false,
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Tunggu verifikasi dari admin.');
    }
}