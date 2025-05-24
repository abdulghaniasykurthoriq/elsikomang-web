<?php

namespace Database\Seeders;

use App\Models\KategoriProduk;
use App\Models\MemberUmkm;
use App\Models\ProdukImage;
use App\Models\ProdukUmkm;
use Illuminate\Database\Seeder;

class ProdukUmkmMassSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil kategori dari yang sudah di-seed sebelumnya
        $kategoriMakanan     = KategoriProduk::where('name', 'Makanan')->first();
        $kategoriMinuman     = KategoriProduk::where('name', 'Minuman')->first();
        $kategoriFashion     = KategoriProduk::where('name', 'Fashion')->first();
        $kategoriKerajinan   = KategoriProduk::where('name', 'Kerajinan Tangan')->first();
        $kategoriElektronik  = KategoriProduk::where('name', 'Elektronik')->first();

        // Validasi kategori
        if (!$kategoriMakanan || !$kategoriMinuman || !$kategoriFashion || !$kategoriKerajinan || !$kategoriElektronik) {
            throw new \Exception("Pastikan semua kategori tersedia di tabel kategori_produk");
        }

        // Buat 1 member UMKM (dummy)
        $member = MemberUmkm::firstOrCreate(
            ['no_hp' => '081234567890'],
            [
                'nama_toko' => 'Toko Admin Pusat',
                'alamat' => 'Jl. Melati No. 123, Bandung',
                'foto_toko' => 'foto_toko/toko-dumy.png',
                'created_by' => 'Seeder',
            ]
        );

        // ===============================
        // Produk 1
        $produk1 = ProdukUmkm::create([
            'member_id' => $member->id,
            'nama_produk' => 'Keripik Pisang Manis',
            'kategori_id' => $kategoriMakanan->id,
            'deskripsi' => 'Keripik pisang renyah dan manis, cocok untuk camilan.',
            'created_by' => 'Seeder',
        ]);
        ProdukImage::create([
            'produk_umkm_id' => $produk1->id,
            'file_path' => 'produk_image/keripik-pisang.jpg',
            'type' => 'image',
        ]);
        $produk1->produk_variant()->createMany([
            ['varian' => '100g', 'harga' => 10000, 'stok' => 20],
            ['varian' => '200g', 'harga' => 18000, 'stok' => 15],
        ]);

        // ===============================
        // Produk 2
        $produk2 = ProdukUmkm::create([
            'member_id' => $member->id,
            'nama_produk' => 'Kopi Arabika Asli',
            'kategori_id' => $kategoriMinuman->id,
            'deskripsi' => 'Kopi arabika dari pegunungan Jawa Barat.',
            'created_by' => 'Seeder',
        ]);
        ProdukImage::create([
            'produk_umkm_id' => $produk2->id,
            'file_path' => 'produk_image/kopi-arabika.jpg',
            'type' => 'image',
        ]);
        $produk2->produk_variant()->create([
            'varian' => '250g',
            'harga' => 45000,
            'stok' => 10,
        ]);

        // ===============================
        // Produk 3
        $produk3 = ProdukUmkm::create([
            'member_id' => $member->id,
            'nama_produk' => 'Tas Tenun Etnik',
            'kategori_id' => $kategoriFashion->id,
            'deskripsi' => 'Tas modis berbahan tenun khas Indonesia.',
            'created_by' => 'Seeder',
        ]);
        ProdukImage::create([
            'produk_umkm_id' => $produk3->id,
            'file_path' => 'produk_image/tas-tenun.jpg',
            'type' => 'image',
        ]);
        $produk3->produk_variant()->create([
            'varian' => 'All Size',
            'harga' => 125000,
            'stok' => 5,
        ]);

        // ===============================
        // Lanjutkan dengan produk 4 - 100 sesuai pola di atas...
    }
}
