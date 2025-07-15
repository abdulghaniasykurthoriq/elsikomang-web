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
            [
                'nama_produk' => 'Madu Hutan Sumbawa',
                'deskripsi' => 'Madu Hutan Sumbawa berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 230, 'harga' => 62131, 'stok' => 8],
                    ['varian' => 'Ukuran Besar', 'berat' => 774, 'harga' => 180913, 'stok' => 3],
                ],
                'gambar' => 'produk_image/madu-hutan-sumbawa.jpg',
                'kategori_id' => 5
            ],
            [
                'nama_produk' => 'Teh Daun Jati Cina',
                'deskripsi' => 'Teh Daun Jati Cina berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 448, 'harga' => 54923, 'stok' => 9],
                    ['varian' => 'Ukuran Besar', 'berat' => 703, 'harga' => 93611, 'stok' => 3],
                ],
                'gambar' => 'produk_image/teh-daun-jati-cina.jpg',
                'kategori_id' => 5
            ],
            [
                'nama_produk' => 'Kopi Gayo',
                'deskripsi' => 'Kopi Gayo berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 431, 'harga' => 55735, 'stok' => 4],
                    ['varian' => 'Ukuran Besar', 'berat' => 912, 'harga' => 131515, 'stok' => 1],
                ],
                'gambar' => 'produk_image/kopi-gayo.jpg',
                'kategori_id' => 4
            ],
            [
                'nama_produk' => 'Keripik Pisang Coklat',
                'deskripsi' => 'Keripik Pisang Coklat berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 470, 'harga' => 62307, 'stok' => 5],
                    ['varian' => 'Ukuran Besar', 'berat' => 686, 'harga' => 186570, 'stok' => 2],
                ],
                'gambar' => 'produk_image/keripik-pisang-coklat.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Minyak Kelapa Murni',
                'deskripsi' => 'Minyak Kelapa Murni berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 258, 'harga' => 21603, 'stok' => 10],
                    ['varian' => 'Ukuran Besar', 'berat' => 951, 'harga' => 166826, 'stok' => 4],
                ],
                'gambar' => 'produk_image/minyak-kelapa-murni.jpg',
                'kategori_id' => 4
            ],
            [
                'nama_produk' => 'Sambal Roa',
                'deskripsi' => 'Sambal Roa berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 271, 'harga' => 33523, 'stok' => 4],
                    ['varian' => 'Ukuran Besar', 'berat' => 623, 'harga' => 113872, 'stok' => 5],
                ],
                'gambar' => 'produk_image/sambal-roa.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Jus Buah Naga',
                'deskripsi' => 'Jus Buah Naga berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 441, 'harga' => 33855, 'stok' => 3],
                    ['varian' => 'Ukuran Besar', 'berat' => 727, 'harga' => 112818, 'stok' => 5],
                ],
                'gambar' => 'produk_image/jus-buah-naga.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Kerupuk Udang Asli',
                'deskripsi' => 'Kerupuk Udang Asli berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 499, 'harga' => 66162, 'stok' => 7],
                    ['varian' => 'Ukuran Besar', 'berat' => 636, 'harga' => 108308, 'stok' => 5],
                ],
                'gambar' => 'produk_image/kerupuk-udang-asli.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Susu Kambing Etawa',
                'deskripsi' => 'Susu Kambing Etawa berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 457, 'harga' => 23663, 'stok' => 9],
                    ['varian' => 'Ukuran Besar', 'berat' => 719, 'harga' => 172835, 'stok' => 4],
                ],
                'gambar' => 'produk_image/susu-kambing-etawa.jpg',
                'kategori_id' => 3
            ],
            [
                'nama_produk' => 'Coklat Kakao Organik',
                'deskripsi' => 'Coklat Kakao Organik berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 442, 'harga' => 55686, 'stok' => 6],
                    ['varian' => 'Ukuran Besar', 'berat' => 676, 'harga' => 188850, 'stok' => 5],
                ],
                'gambar' => 'produk_image/coklat-kakao-organik.jpg',
                'kategori_id' => 4
            ],
            [
                'nama_produk' => 'Baju Koko Pria',
                'deskripsi' => 'Baju Koko Pria berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 215, 'harga' => 20849, 'stok' => 10],
                    ['varian' => 'Ukuran Besar', 'berat' => 669, 'harga' => 156959, 'stok' => 1],
                ],
                'gambar' => 'produk_image/baju-koko-pria.jpg',
                'kategori_id' => 4
            ],
            [
                'nama_produk' => 'Jaket Denim Wanita',
                'deskripsi' => 'Jaket Denim Wanita berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 491, 'harga' => 66810, 'stok' => 10],
                    ['varian' => 'Ukuran Besar', 'berat' => 795, 'harga' => 197850, 'stok' => 5],
                ],
                'gambar' => 'produk_image/jaket-denim-wanita.jpg',
                'kategori_id' => 2
            ],
            [
                'nama_produk' => 'Sepatu Sneakers Lokal',
                'deskripsi' => 'Sepatu Sneakers Lokal berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 419, 'harga' => 33719, 'stok' => 9],
                    ['varian' => 'Ukuran Besar', 'berat' => 679, 'harga' => 192938, 'stok' => 5],
                ],
                'gambar' => 'produk_image/sepatu-sneakers-lokal.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Gamis Syari',
                'deskripsi' => 'Gamis Syari berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 326, 'harga' => 30865, 'stok' => 6],
                    ['varian' => 'Ukuran Besar', 'berat' => 789, 'harga' => 126913, 'stok' => 2],
                ],
                'gambar' => 'produk_image/gamis-syari.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Kaos Polos Premium',
                'deskripsi' => 'Kaos Polos Premium berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 442, 'harga' => 76137, 'stok' => 7],
                    ['varian' => 'Ukuran Besar', 'berat' => 950, 'harga' => 164752, 'stok' => 3],
                ],
                'gambar' => 'produk_image/kaos-polos-premium.jpg',
                'kategori_id' => 5
            ],
            [
                'nama_produk' => 'Dompet Kulit Sapi',
                'deskripsi' => 'Dompet Kulit Sapi berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 210, 'harga' => 66656, 'stok' => 9],
                    ['varian' => 'Ukuran Besar', 'berat' => 782, 'harga' => 151382, 'stok' => 3],
                ],
                'gambar' => 'produk_image/dompet-kulit-sapi.jpg',
                'kategori_id' => 2
            ],
            [
                'nama_produk' => 'Gelang Manik Etnik',
                'deskripsi' => 'Gelang Manik Etnik berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 377, 'harga' => 76643, 'stok' => 10],
                    ['varian' => 'Ukuran Besar', 'berat' => 805, 'harga' => 183289, 'stok' => 1],
                ],
                'gambar' => 'produk_image/gelang-manik-etnik.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Kalung Batu Alam',
                'deskripsi' => 'Kalung Batu Alam berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 421, 'harga' => 58598, 'stok' => 8],
                    ['varian' => 'Ukuran Besar', 'berat' => 743, 'harga' => 143218, 'stok' => 3],
                ],
                'gambar' => 'produk_image/kalung-batu-alam.jpg',
                'kategori_id' => 2
            ],
            [
                'nama_produk' => 'Tas Rajut Handmade',
                'deskripsi' => 'Tas Rajut Handmade berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 377, 'harga' => 45199, 'stok' => 10],
                    ['varian' => 'Ukuran Besar', 'berat' => 873, 'harga' => 136831, 'stok' => 2],
                ],
                'gambar' => 'produk_image/tas-rajut-handmade.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Topi Tenun Tradisional',
                'deskripsi' => 'Topi Tenun Tradisional berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 288, 'harga' => 59551, 'stok' => 4],
                    ['varian' => 'Ukuran Besar', 'berat' => 873, 'harga' => 136056, 'stok' => 2],
                ],
                'gambar' => 'produk_image/topi-tenun-tradisional.jpg',
                'kategori_id' => 5
            ],
            [
                'nama_produk' => 'Headset Gaming',
                'deskripsi' => 'Headset Gaming berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 434, 'harga' => 57100, 'stok' => 6],
                    ['varian' => 'Ukuran Besar', 'berat' => 871, 'harga' => 85178, 'stok' => 4],
                ],
                'gambar' => 'produk_image/headset-gaming.jpg',
                'kategori_id' => 3
            ],
            [
                'nama_produk' => 'Smartwatch Waterproof',
                'deskripsi' => 'Smartwatch Waterproof berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 337, 'harga' => 71150, 'stok' => 6],
                    ['varian' => 'Ukuran Besar', 'berat' => 654, 'harga' => 102659, 'stok' => 5],
                ],
                'gambar' => 'produk_image/smartwatch-waterproof.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Power Bank 20000mAh',
                'deskripsi' => 'Power Bank 20000mAh berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 256, 'harga' => 68729, 'stok' => 6],
                    ['varian' => 'Ukuran Besar', 'berat' => 669, 'harga' => 127687, 'stok' => 1],
                ],
                'gambar' => 'produk_image/power-bank-20000mah.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Kamera Mini HD',
                'deskripsi' => 'Kamera Mini HD berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 293, 'harga' => 23026, 'stok' => 10],
                    ['varian' => 'Ukuran Besar', 'berat' => 793, 'harga' => 109345, 'stok' => 3],
                ],
                'gambar' => 'produk_image/kamera-mini-hd.jpg',
                'kategori_id' => 5
            ],
            [
                'nama_produk' => 'Mouse Wireless RGB',
                'deskripsi' => 'Mouse Wireless RGB berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 439, 'harga' => 72915, 'stok' => 9],
                    ['varian' => 'Ukuran Besar', 'berat' => 748, 'harga' => 181058, 'stok' => 5],
                ],
                'gambar' => 'produk_image/mouse-wireless-rgb.jpg',
                'kategori_id' => 5
            ],
            [
                'nama_produk' => 'Laptop Sleeve Kulit',
                'deskripsi' => 'Laptop Sleeve Kulit berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 274, 'harga' => 23282, 'stok' => 9],
                    ['varian' => 'Ukuran Besar', 'berat' => 811, 'harga' => 104683, 'stok' => 4],
                ],
                'gambar' => 'produk_image/laptop-sleeve-kulit.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Sabun Susu Kambing',
                'deskripsi' => 'Sabun Susu Kambing berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 209, 'harga' => 39642, 'stok' => 9],
                    ['varian' => 'Ukuran Besar', 'berat' => 681, 'harga' => 91494, 'stok' => 2],
                ],
                'gambar' => 'produk_image/sabun-susu-kambing.jpg',
                'kategori_id' => 5
            ],
            [
                'nama_produk' => 'Minuman Jahe Merah',
                'deskripsi' => 'Minuman Jahe Merah berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 313, 'harga' => 71282, 'stok' => 10],
                    ['varian' => 'Ukuran Besar', 'berat' => 867, 'harga' => 115477, 'stok' => 3],
                ],
                'gambar' => 'produk_image/minuman-jahe-merah.jpg',
                'kategori_id' => 3
            ],
            [
                'nama_produk' => 'Nugget Ikan Laut',
                'deskripsi' => 'Nugget Ikan Laut berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 399, 'harga' => 57923, 'stok' => 4],
                    ['varian' => 'Ukuran Besar', 'berat' => 989, 'harga' => 175886, 'stok' => 1],
                ],
                'gambar' => 'produk_image/nugget-ikan-laut.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Abon Sapi Asli',
                'deskripsi' => 'Abon Sapi Asli berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 303, 'harga' => 32814, 'stok' => 10],
                    ['varian' => 'Ukuran Besar', 'berat' => 839, 'harga' => 173752, 'stok' => 1],
                ],
                'gambar' => 'produk_image/abon-sapi-asli.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Pasta Gigi Herbal',
                'deskripsi' => 'Pasta Gigi Herbal berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 241, 'harga' => 56101, 'stok' => 7],
                    ['varian' => 'Ukuran Besar', 'berat' => 908, 'harga' => 131166, 'stok' => 4],
                ],
                'gambar' => 'produk_image/pasta-gigi-herbal.jpg',
                'kategori_id' => 3
            ],
            [
                'nama_produk' => 'Kue Kering Lebaran',
                'deskripsi' => 'Kue Kering Lebaran berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 203, 'harga' => 38728, 'stok' => 6],
                    ['varian' => 'Ukuran Besar', 'berat' => 656, 'harga' => 190058, 'stok' => 2],
                ],
                'gambar' => 'produk_image/kue-kering-lebaran.jpg',
                'kategori_id' => 4
            ],
            [
                'nama_produk' => 'Dress Batik Wanita',
                'deskripsi' => 'Dress Batik Wanita berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 492, 'harga' => 60012, 'stok' => 9],
                    ['varian' => 'Ukuran Besar', 'berat' => 877, 'harga' => 129661, 'stok' => 2],
                ],
                'gambar' => 'produk_image/dress-batik-wanita.jpg',
                'kategori_id' => 3
            ],
            [
                'nama_produk' => 'Sandal Jepit Anyaman',
                'deskripsi' => 'Sandal Jepit Anyaman berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 393, 'harga' => 38377, 'stok' => 5],
                    ['varian' => 'Ukuran Besar', 'berat' => 655, 'harga' => 186556, 'stok' => 4],
                ],
                'gambar' => 'produk_image/sandal-jepit-anyaman.jpg',
                'kategori_id' => 4
            ],
            [
                'nama_produk' => 'Celana Jeans Slimfit',
                'deskripsi' => 'Celana Jeans Slimfit berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 475, 'harga' => 55307, 'stok' => 7],
                    ['varian' => 'Ukuran Besar', 'berat' => 722, 'harga' => 80451, 'stok' => 3],
                ],
                'gambar' => 'produk_image/celana-jeans-slimfit.jpg',
                'kategori_id' => 1
            ],
            [
                'nama_produk' => 'Rompi Pria Stylish',
                'deskripsi' => 'Rompi Pria Stylish berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 446, 'harga' => 60878, 'stok' => 10],
                    ['varian' => 'Ukuran Besar', 'berat' => 859, 'harga' => 148196, 'stok' => 5],
                ],
                'gambar' => 'produk_image/rompi-pria-stylish.jpg',
                'kategori_id' => 4
            ],
            [
                'nama_produk' => 'Lukisan Tangan Unik',
                'deskripsi' => 'Lukisan Tangan Unik berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 394, 'harga' => 57943, 'stok' => 3],
                    ['varian' => 'Ukuran Besar', 'berat' => 601, 'harga' => 157504, 'stok' => 5],
                ],
                'gambar' => 'produk_image/lukisan-tangan-unik.jpg',
                'kategori_id' => 2
            ],
            [
                'nama_produk' => 'Patung Kayu Tradisional',
                'deskripsi' => 'Patung Kayu Tradisional berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 468, 'harga' => 27300, 'stok' => 8],
                    ['varian' => 'Ukuran Besar', 'berat' => 972, 'harga' => 81730, 'stok' => 3],
                ],
                'gambar' => 'produk_image/patung-kayu-tradisional.jpg',
                'kategori_id' => 5
            ],
            [
                'nama_produk' => 'Vas Bunga Keramik',
                'deskripsi' => 'Vas Bunga Keramik berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 423, 'harga' => 74718, 'stok' => 6],
                    ['varian' => 'Ukuran Besar', 'berat' => 702, 'harga' => 121906, 'stok' => 4],
                ],
                'gambar' => 'produk_image/vas-bunga-keramik.jpg',
                'kategori_id' => 4
            ],
            [
                'nama_produk' => 'Bingkai Foto Vintage',
                'deskripsi' => 'Bingkai Foto Vintage berkualitas tinggi dan populer di kalangan konsumen.',
                'varian' => [
                    ['varian' => 'Ukuran Kecil', 'berat' => 415, 'harga' => 34095, 'stok' => 8],
                    ['varian' => 'Ukuran Besar', 'berat' => 974, 'harga' => 144866, 'stok' => 3],
                ],
                'gambar' => 'produk_image/bingkai-foto-vintage.jpg',
                'kategori_id' => 1
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
