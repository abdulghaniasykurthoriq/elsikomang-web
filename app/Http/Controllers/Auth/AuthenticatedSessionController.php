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
        $request->session()->regenerate();

        $user = Auth::user();
        $role = strtolower($user->role);

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'operator umkm':
                return redirect()->route('ProdukUmkm.dashboard');
            case 'operator pariwisata':
                return redirect()->route('pariwisata.dashboard');
            case 'operator investasi':
                return redirect()->route('investasi.dashboard');
            case 'operator entertainment':
                return redirect()->route('entertainment.dashboard');
            case 'operator event':
                return redirect()->route('event.dashboard');
            case 'operator box office':
                return redirect()->route('box-office.dashboard');
            default:
                abort(403, 'Role tidak dikenali.');
        }
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

            switch ($role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'operator umkm':
                    return redirect()->route('ProdukUmkm.dashboard');
                case 'operator pariwisata':
                    return redirect()->route('pariwisata.dashboard');
                case 'operator investasi':
                    return redirect()->route('investasi.dashboard');
                case 'operator entertainment':
                    return redirect()->route('entertainment.dashboard');
                case 'operator event':
                    return redirect()->route('event.dashboard');
                case 'operator box office':
                    return redirect()->route('box-office.dashboard');
                default:
                    abort(403, 'Role tidak dikenali.');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login Google gagal: ' . $e->getMessage());
        }
    }
}
