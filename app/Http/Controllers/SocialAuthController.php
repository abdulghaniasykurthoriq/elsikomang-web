<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return response()->json([
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    // public function handleGoogleCallback(Request $request)
    // {
    //     try {
            
    //     $googleUser = Socialite::driver('google')->stateless()->user();

    //     return response()->json([
    //         'message' => 'Login berhasil!',
    //         'user' => [
    //             'name' => $googleUser->getName(),
    //             'email' => $googleUser->getEmail(),
    //             'google_id' => $googleUser->getId(),
    //             'avatar' => $googleUser->getAvatar(),
    //         ]
    //     ]);
    // } catch (\Exception $e) {
    //     return response()->json(['error' => 'Google login gagal', 'message' => $e->getMessage()], 500);
    // }
    //     // try {
    //     //     $googleUser = Socialite::driver('google')->stateless()->user();

    //     //     // Cek apakah user sudah ada
    //     //     $user = User::where('email', $googleUser->getEmail())->first();

    //     //     if (!$user) {
    //     //         $user = User::create([
    //     //             'name' => $googleUser->getName(),
    //     //             'email' => $googleUser->getEmail(),
    //     //             'google_id' => $googleUser->getId(),
    //     //             'avatar' => $googleUser->getAvatar(),
    //     //             'password' => bcrypt(uniqid()), // Random password
    //     //         ]);
    //     //     }

    //     //     // Buat JWT Token
    //     //     $token = JWTAuth::fromUser($user);

    //     //     return response()->json([
    //     //         'message' => 'Login successful',
    //     //         'user' => $user,
    //     //         'token' => $token,
    //     //     ]);
    //     // } catch (\Exception $e) {
    //     //     return response()->json(['error' => 'Google login failed'], 500);
    //     // }
    // }




    public function handleGoogleCallback(Request $request)
{
    try {
        // Mendapatkan data user dari Google
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Menyiapkan data yang akan dikirimkan
        $name = $googleUser->getName();
        $email = $googleUser->getEmail();
        $googleId = $googleUser->getId();
        $avatar = $googleUser->getAvatar();

        // Membuat URL dengan query parameters untuk aplikasi Flutter
        $redirectUrl = 'myapp://callback?name=' . urlencode($name) . 
                       '&email=' . urlencode($email) . 
                       '&google_id=' . urlencode($googleId) . 
                       '&avatar=' . urlencode($avatar);

        // Redirect ke URL aplikasi Flutter dengan data
        return redirect()->away($redirectUrl);
        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Google login gagal', 'message' => $e->getMessage()], 500);
    }
}

}
