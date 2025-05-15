<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        

        $request->authenticate();
        if($request->user()->role == 'User'){
            return redirect()->route('login')->with('error', 'Akun  ini belum terdaftar.');

        };
        // dd($request->user());
        
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}
    public function handleGoogleCallback(Request $request)
{
    try {
        // Ambil data user dari Google
        $googleUser = Socialite::driver('google')->stateless()->user();
        

        // Ambil email dari Google
        $email = $googleUser->getEmail();
        // dd($email);

        // Cek apakah user sudah ada di database
        $user = User::where('email', $email)->first();
        // dd($user);

        if (!$user) {
            // Jika user belum terdaftar, redirect ke halaman login dengan pesan error
            return redirect()->route('login')->with('error', 'Akun Google ini belum terdaftar.');
        }

Auth::login($user); // ini seharusnya melakukan login
$request->session()->regenerate();
return redirect()->intended(route('dashboard', absolute: false));

        // return redirect()->intended(route('dashboard', absolute: false));
    } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'Login Google gagal: ' . $e->getMessage());
    }
}



    
}
