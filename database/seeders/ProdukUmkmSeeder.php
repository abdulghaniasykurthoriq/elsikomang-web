<?php

namespace Database\Seeders;

use App\Models\MemberUmkm;
use App\Models\ProdukImage;
use App\Models\ProdukUmkm;
use Illuminate\Database\Seeder;

class ProdukUmkmSeeder extends Seeder
{
    public function run(): void
    {
        $member = MemberUmkm::create([
            'nama_toko' => 'Toko Admin Pusat',
            'alamat' => 'Jl. Melati No. 123, Bandung',
            'no_hp' => '081234567890',
            'foto_toko' => 'foto_toko/toko-dumy.png',
            'created_by' => '1',
            'desa_id' => 1234
        ]);

        $kategoriId = 2; // contoh kategori makanan

        $produkList = [
            [
                'nama_produk' => 'Kopi Gayo Premium',
                'deskripsi' => 'Kopi asli dari dataran tinggi Gayo.',
                'varian' => [
                    ['varian' => '250g', 'berat' => 800, 'harga' => 40000, 'stok' => 10],
                    ['varian' => '500g', 'berat' => 800, 'harga' => 75000, 'stok' => 5],
                ],
                'gambar' => 'produk_image/dummy.jpg',
            ],
            [
                'nama_produk' => 'Teh Hijau Organik',
                'deskripsi' => 'Teh hijau berkualitas dari kebun lokal.',
                'varian' => [
                    ['varian' => '100g', 'berat' => 800, 'harga' => 25000, 'stok' => 20],
                    ['varian' => '250g', 'berat' => 800, 'harga' => 55000, 'stok' => 8],
                ],
                'gambar' => 'produk_image/teh-hijau.jpg',
            ],
            [
                'nama_produk' => 'Keripik Singkong Pedas',
                'deskripsi' => 'Keripik singkong dengan rasa pedas mantap.',
                'varian' => [
                    ['varian' => '50g', 'berat' => 800, 'harga' => 15000, 'stok' => 30],
                    ['varian' => '100g', 'berat' => 800, 'harga' => 28000, 'stok' => 15],
                ],
                'gambar' => 'produk_image/keripik-singkong.jpg',
            ],
            [
                'nama_produk' => 'Sambal Terasi Asli',
                'deskripsi' => 'Sambal terasi dengan cita rasa tradisional.',
                'varian' => [
                    ['varian' => '150ml', 'berat' => 800, 'harga' => 20000, 'stok' => 25],
                ],
                'gambar' => 'produk_image/sambal-terasi.jpg',
            ],
            [
                'nama_produk' => 'Madu Hutan Sumbawa',
                'deskripsi' => 'Madu asli dari hutan Sumbawa yang murni.',
                'varian' => [
                    ['varian' => '250ml', 'berat' => 800, 'harga' => 90000, 'stok' => 7],
                    ['varian' => '500ml', 'berat' => 800, 'harga' => 170000, 'stok' => 4],
                ],
                'gambar' => 'produk_image/madu-hutan.jpg',
            ],
            [
                'nama_produk' => 'Minyak Kelapa Dara',
                'deskripsi' => 'Minyak kelapa murni untuk kesehatan.',
                'varian' => [
                    ['varian' => '300ml', 'berat' => 800, 'harga' => 120000, 'stok' => 10],
                ],
                'gambar' => 'produk_image/minyak-kelapa.jpg',
            ],
            [
                'nama_produk' => 'Cokelat Artisan Premium',
                'deskripsi' => 'Cokelat buatan tangan kualitas premium.',
                'varian' => [
                    ['varian' => '200g', 'berat' => 800, 'harga' => 135000, 'stok' => 10],
                ],
                'gambar' => 'produk_image/cokelat.jpg',
            ],
            [
                'nama_produk' => 'Kacang Mede Panggang',
                'deskripsi' => 'Kacang mede asli dengan rasa gurih.',
                'varian' => [
                    ['varian' => '250g', 'berat' => 800, 'harga' => 70000, 'stok' => 20],
                ],
                'gambar' => 'produk_image/kacang.jpg',
            ],
            [
                'nama_produk' => 'Sirup Markisa Premium',
                'deskripsi' => 'Sirup dari markisa asli, segar dan nikmat.',
                'varian' => [
                    ['varian' => '600ml', 'berat' => 800, 'harga' => 105000, 'stok' => 6],
                ],
                'gambar' => 'produk_image/sirup.jpg',
            ],
            [
                'nama_produk' => 'Kopi Luwak Eksklusif',
                'deskripsi' => 'Kopi luwak pilihan, sangat langka.',
                'varian' => [
                    ['varian' => '200g', 'berat' => 800, 'harga' => 250000, 'stok' => 2],
                ],
                'gambar' => 'produk_image/kopi-luwak.jpg',
            ],
        ];

        foreach ($produkList as $item) {
            $produk = ProdukUmkm::create([
                'member_id' => $member->id,
                'nama_produk' => $item['nama_produk'],
                'kategori_id' => $kategoriId,
                'deskripsi' => $item['deskripsi'],
                'created_by' => 'Seeder',
            ]);

            ProdukImage::create([
                'produk_umkm_id' => $produk->id,
                'file_path' => $item['gambar'],
                'type' => 'image',
            ]);

            foreach ($item['varian'] as $varian) {
                $produk->produk_variant()->create($varian);
            }
        }
    }
}
