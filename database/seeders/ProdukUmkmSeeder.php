<?php

namespace Database\Seeders;

use App\Models\MemberUmkm;
use App\Models\ProdukImage;
use App\Models\ProdukUmkm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukUmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        
        $memberId = 1;
        $kategoriId = 2; // ini adalah kategori makanan yg udah ada di seeder

        $fotoTokoPath = 'foto_toko/toko-dumy.png'; // pastikan file ini ada di public/storage/foto_toko

        MemberUmkm::create([
            'nama_toko' => 'Toko Admin Pusat',
            'alamat' => 'Jl. Melati No. 123, Bandung',
            'no_hp' => '081234567890',
            'foto_toko' => $fotoTokoPath,
            'created_by' => '1',
        ]);

        $produk = ProdukUmkm::create([
            'member_id' => $memberId,
            'nama_produk' => 'Kopi Gayo Premium',
            'kategori_id' => $kategoriId,
            'deskripsi' => 'Kopi asli dari dataran tinggi Gayo.',
            'created_by' => 'Seeder',
        ]);

        // Simulasi gambar (pastikan file dummy tersedia)
        $dummyImagePath = 'produk_image/dummy.jpg'; 

        ProdukImage::create([
            'produk_umkm_id' => $produk->id,
            'file_path' => $dummyImagePath,
            'type' => 'image',
        ]);

        // Simulasi varian
        $varianData = [
            ['varian' => '250g', 'harga' => 40000, 'stok' => 10],
            ['varian' => '500g', 'harga' => 75000, 'stok' => 5],
        ];

        foreach ($varianData as $dataVarian) {
            $produk->produk_variant()->create($dataVarian);
        }
    }
}
