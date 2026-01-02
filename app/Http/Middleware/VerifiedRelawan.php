<?php

    namespace App\Http\Middleware;

    use Closure;
    use illuminate\Http\Request;
    use Symfony\Component\HttpFoundation\Response;

    class VerifiedRelawan
    {
        public function handle(Request $request, Closure $netxt): Response
        {
            if (auth()->check() && auth()->user()->role === 'relawan'){
                if (!auth()->user()->is_verified) {
                    return redirect()->route('login')
                    ->whithErrors(['email' => 'Akun anda belum diverevikasi oleh admin. Silahkan tunggu proses verifikasi.']);
                }
            }
            return $netxt($request);
        }
    }