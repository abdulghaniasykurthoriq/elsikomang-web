<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CoverMenu;
use Illuminate\Http\Request;

class CoverMenuController extends Controller
{
    public function index()
    {
        $coverMenus = CoverMenu::paginate(10);
        // dd($coverMenus->first());
        if ($coverMenus->isEmpty()) {
            return response()->json(['message' => 'Tidak ada item cover menu ditemukan'], 200);
        }
        return response()->json($coverMenus);
    }
}
