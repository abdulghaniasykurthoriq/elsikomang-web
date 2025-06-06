<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Google\Client as GoogleClient;

class AuthController extends Controller
{

    public function register(UserRegisterRequest $request)
    {
        $validateData = $request->validated();
        $user = User::create([
            'name' => $validateData['name'],
            'email' => $validateData['email'],
            'no_telephon' => $validateData['no_telephon'],
            'password' => bcrypt($validateData['password'])
        ]);
        return response()->json([
            'message' => 'Berhasil Mendaftar, Silahkan Login',
            'user' => $user
        ]);
    }

    public function update(UserProfileUpdateRequest $request)
    {
        $validateData = $request->validated();
        $user = auth('api')->user();
        $user->update($validateData); // Update langsung dengan data tervalidasi

        return response()->json([
            'message' => 'Profil berhasil diperbarui.',
            'user' => $user
        ]);

    }
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }

            $path = $request->file('foto')->store('foto_profil', 'public'); // Simpan di direktori 'foto_profil' di dalam 'public' disk
            $user->foto = $path;
        }

        $user->save(); // Jangan lupa menyimpan perubahan pada model User

        return response()->json(['message' => 'Foto profil berhasil diperbarui.']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = auth()->user();

        if (!Auth::attempt(['email' => $user->email, 'password' => $request->current_password])) {
            return response()->json(['error' => 'Current password is incorrect.'], 422);
        }

        $user->update([
            'password' => bcrypt($request->new_password)
        ]);

        return response()->json(['message' => 'Password updated successfully.']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth('api')->user();

        if (!$user || $user->role !== 'User') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Buat dan simpan refresh token
        $refreshToken = Str::random(60);
        $user->refresh_token = hash('sha256', $refreshToken);
        $user->refresh_token_expires_at = now()->addDays(30); 
        $user->save();

        // expires dalam menit ya 

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL(),
            'refresh_token' => $refreshToken,
            'refresh_token_expires_at' => now()->addDays(30)->toDateTimeString()
        ]);
    }

    public function google(Request $request)
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        // Verifikasi ID token dari Google
        $client = new GoogleClient(['client_id' => env('GOOGLE_CLIENT_ID')]);
        $payload = $client->verifyIdToken($request->id_token);

        if (!$payload) {
            return response()->json(['message' => 'Invalid Google ID token'], 401);
        }

        // Ambil data user dari payload
        $email = $payload['email'];
        $name = $payload['name'] ?? 'Google User';

        // Cek apakah user sudah ada
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Jika belum ada, buat user baru
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt(Str::random(16)), // Dummy password
                'email_verified_at' => now(),
            ]);
        }

        if (!$token = auth('api')->login($user)) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        // Simpan refresh token
        $refreshToken = Str::random(60);
        $refreshTokenExpiresAt = now()->addDays(30);

        $user->refresh_token = hash('sha256', $refreshToken);
        $user->refresh_token_expires_at = $refreshTokenExpiresAt;
        $user->save();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL(),
            'refresh_token' => $refreshToken,
            'refresh_token_expires_at' => $refreshTokenExpiresAt->toDateTimeString(),
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        $user = auth('api')->user();

        if ($user) {
            // Clear refresh token saat logout
            $user->refresh_token = null;
            $user->refresh_token_expires_at = null;
            $user->save();
        }

        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->refresh_token;

        if (!$refreshToken) {
            return response()->json(['error' => 'Refresh token is required'], 400);
        }

        $user = User::where('refresh_token', hash('sha256', $refreshToken))
            ->where('refresh_token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid or expired refresh token'], 401);
        }

        // Login ulang untuk dapatkan access token baru
        $newAccessToken = auth('api')->login($user);

        return response()->json([
            'access_token' => $newAccessToken,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ]);
    }
}