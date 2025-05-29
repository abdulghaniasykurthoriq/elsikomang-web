<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        if($user->role !== 'User'){

            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Hanya user yang bisa login'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
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