<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\KritikDanSaranStoreRequest;
use App\Models\KritikDanSaran;

class KritikDanSaranController extends Controller
{
    public function create(KritikDanSaranStoreRequest $request)
    {
        $validated = $request->validated();
        $data = KritikDanSaran::create($validated);
        return response()->json([
            'message' => 'Kritik dan saran berhasil dikirim.',
            'data'    => $data
        ], 201);
    }

}
