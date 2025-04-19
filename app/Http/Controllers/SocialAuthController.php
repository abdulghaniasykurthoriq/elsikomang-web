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

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $name = $googleUser->getName();
            $email = $googleUser->getEmail();
            $googleId = $googleUser->getId();
            $avatar = $googleUser->getAvatar();

            $redirectUrl = 'myapp://callback?name=' . urlencode($name) . 
                        '&email=' . urlencode($email) . 
                        '&google_id=' . urlencode($googleId) . 
                        '&avatar=' . urlencode($avatar);

            return redirect()->away($redirectUrl);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Google login gagal', 'message' => $e->getMessage()], 500);
        }
    }

}
