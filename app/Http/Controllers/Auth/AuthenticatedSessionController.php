<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

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
        $request->session()->regenerate();

        $user = Auth::user();
        $role = strtolower($user->role);

        if ($role === 'admin') {
            return redirect()->route('dashboard'); // pastikan route ini sesuai web.php
        }

        if (Str::startsWith($role, 'operator')) {
            if ($user->jenisOperator && $user->jenisOperator->url_parameter) {
                $jenis = strtolower($user->jenisOperator->url_parameter);
                return redirect()->route('operator.dashboard', ['jenis' => $jenis]);
            } else {
                abort(403, 'Operator tidak memiliki jenis operator yang valid.');
            }
        }

        abort(403, 'Role tidak dikenali.');
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
            $googleUser = Socialite::driver('google')->user();
            $email = $googleUser->getEmail();
            $user = User::where('email', $email)->first();

            if (!$user) {
                return redirect()->route('login')->with('error', 'Akun Google ini belum terdaftar.');
            }

            Auth::login($user);
            $request->session()->regenerate();

            $role = strtolower($user->role);

            if ($role === 'admin') {
                return redirect()->route('dashboard');
            }

            if (Str::startsWith($role, 'operator') && $user->jenisOperator) {
                $jenis = strtolower($user->jenisOperator->url_parameter);
                return redirect()->route('operator.dashboard', ['jenis' => $jenis]);
            }

            abort(403, 'Role tidak dikenali atau tidak punya jenis operator.');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login Google gagal: ' . $e->getMessage());
        }
    }
}
