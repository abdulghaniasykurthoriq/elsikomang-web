<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        // Logic to retrieve the wishlist items for the authenticated user
        $user = auth()->user();
        $wishlistItems = Wishlist::where('user_id',$user->id)->with(['produkUmkm.images','produkUmkm.member','produkUmkm.produk_variant'])->get();
        
        // Assuming you have a relationship set up

        return response()->json([
            'message' => 'Wishlist retrieved successfully',
            'data' => $wishlistItems
        ]);
    }

    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'produk_umkm_id' => 'required|exists:produk_umkm,id',
        ]);

        $user = auth()->user();

        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('produk_umkm_id', $validated['produk_umkm_id'])
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['message' => 'Wishlist dihapus']);
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'produk_umkm_id' => $validated['produk_umkm_id'],
            ]);
            return response()->json(['message' => 'Wishlist ditambahkan']);
        }
    }
              
}
