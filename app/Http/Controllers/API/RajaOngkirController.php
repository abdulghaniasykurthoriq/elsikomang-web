<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class RajaOngkirController extends Controller
{

    public function checkOngkir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination' => 'required',
            'weight' => 'required|integer|min:1',
            'courier' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $response = Http::withHeaders([
                'key' => config('rajaongkir.api_key'),
            ])->asForm()->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'origin' => $request->origin,
                'destination' => $request->destination,
                'weight' => $request->weight,
                'courier' => $request->courier,
                'price' => 'lowest',
            ]);

            return response()->json([
                'data' => $response->json()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghubungi API RajaOngkir',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
