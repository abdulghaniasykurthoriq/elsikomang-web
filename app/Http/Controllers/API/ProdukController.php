<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search'); // menangkap parameter ?search=

        $allItems = [];

        // Contoh membuat 20 item seolah-olah total data
        for ($i = 1; $i <= 20; $i++) {
            $allItems[] = [
                'id'          => $i,
                'member'      => ['nama' => 'Toko Official'],
                'nama_produk' => 'sepatu ' . $i,
                'category'    => [
                    'nama' => 'fashion'
                ],
                'image'       => [
                    ['url' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.decathlon.co.id%2Fp%2Fsepatu-jogging-pria-run-active-biru-tua-kalenji-8559090.html']
                ],
                'variant'     => [
                    ['jenis' => 'xl', 'harga' => 12000]
                ],
                'deskripsi'   => 'produk keren banget',
                'stock'       => 200,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ];
        }

        // Filter search jika parameter search diisi
        if ($search) {
            $allItems = array_filter($allItems, function ($item) use ($search) {
                return Str::contains(Str::lower($item['nama_produk']), Str::lower($search));
            });

            $allItems = array_values($allItems); // reset key array
        }

        // Pagination manual
        $currentPage = $request->query('page', 1);
        $perPage = $request->query('per_page', 5);
        $offset = ($currentPage - 1) * $perPage;

        $paginatedItems = array_slice($allItems, $offset, $perPage);

        $response = [
            'current_page' => (int) $currentPage,
            'per_page'     => (int) $perPage,
            'total'        => count($allItems),
            'last_page'    => ceil(count($allItems) / $perPage),
            'data'         => $paginatedItems,
        ];

        return response()->json($response);
    }

    public function show($id)
    {
        $data = [
                    'id'          => $id,
                    'member'      => ['nama' => 'Toko Official'],
                    'nama_produk' => 'sepatu ',
                    'category'    => [
                        'nama' => 'fashion'
                    ],
                    'image'       => [
                        ['url' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.decathlon.co.id%2Fp%2Fsepatu-jogging-pria-run-active-biru-tua-kalenji-8559090.html']
                    ],
                    'variant'     => [
                        ['jenis' => 'xl', 'harga' => 12000]
                    ],
                    'deskripsi'   => 'produk keren banget',
                    'stock'       => 200,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                ];

        return response()->json($data);
    }
}
