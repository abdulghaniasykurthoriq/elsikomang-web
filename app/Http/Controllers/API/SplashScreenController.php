<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SplashScreen;
use Illuminate\Http\Request;

class SplashScreenController extends Controller
{
    public function index()
    {
        $splashScreen = SplashScreen::first();
        return response()->json($splashScreen);
        
    }
}
