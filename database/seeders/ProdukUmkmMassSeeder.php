<?php

namespace Database\Seeders;

use App\Models\KategoriProduk;
use App\Models\MemberUmkm;
use App\Models\ProdukImage;
use App\Models\ProdukUmkm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Faker\Factory as Faker;

class ProdukUmkmMassSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil kategori yang tersedia
        $kategoriList = collect([
            'Makanan'     => KategoriProduk::where('name', 'Makanan')->first(),
            'Minuman'     => KategoriProduk::where('name', 'Minuman')->first(),
            'Fashion'     => KategoriProduk::where('name', 'Fashion')->first(),
            'Kerajinan'   => KategoriProduk::where('name', 'Kerajinan Tangan')->first(),
            'Elektronik'  => KategoriProduk::where('name', 'Elektronik')->first(),
        ])->filter(); // Hapus kategori yang null

        if ($kategoriList->isEmpty()) {
            throw new \Exception("Tidak ada kategori yang tersedia di tabel `kategori_produk`.");
        }

        // Ambil satu data desa
        $desaId = DB::table('desas')->value('id');
        if (!$desaId) {
            throw ValidationException::withMessages([
                'desa_id' => 'Minimal 1 data desas harus tersedia di tabel `desas`',
            ]);
        }

        // Buat member dummy
        $member = MemberUmkm::firstOrCreate(
            ['no_hp' => '081234567890'],
            [
                'nama_toko' => 'Toko Admin Pusat',
                'alamat' => 'Jl. Melati No. 123, Bandung',
                'desa_id' => $desaId,
                'foto_toko' => 'foto_toko/toko-dumy.png',
                'created_by' => 'Seeder',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Tambahkan 10 produk acak
        for ($i = 1; $i <= 10; $i++) {
            $kategoriNama = $kategoriList->keys()->random();
            $kategori = $kategoriList[$kategoriNama];

            $produk = ProdukUmkm::create([
                'member_id' => $member->id,
                'nama_produk' => ucfirst($faker->word) . ' ' . $faker->randomElement(['Premium', 'Asli', 'Terbaik']),
                'kategori_id' => $kategori->id,
                'deskripsi' => $faker->sentence(),
                'created_by' => 'Seeder',
                'created_at' => now()->subDays(rand(1, 365)), // biar datanya acak
                'updated_at' => now(),
            ]);

            ProdukImage::create([
                'produk_umkm_id' => $produk->id,
                'file_path' => 'produk_image/sample-' . $i . '.jpg',
                'type' => 'image',
            ]);

            // Tambahkan 1-3 varian
            for ($v = 0; $v < rand(1, 3); $v++) {
                $produk->produk_variant()->create([
                    'varian' => $faker->randomElement(['100g', '250g', '500g', 'All Size', 'Botol']) . ' ' . strtoupper($faker->randomLetter),
                    'berat' => $faker->numberBetween(100, 1000),
                    'harga' => $faker->numberBetween(5000, 750000),
                    'stok' => $faker->numberBetween(1, 100),
                    'created_by' => 'Seeder',
                    'updated_by' => 'Seeder',
                    'created_at' => now()->subDays(rand(1, 365)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
