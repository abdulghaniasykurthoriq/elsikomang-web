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
                [
                    'nama_produk' => 'Keripik Singkong Pedas',
                    'deskripsi' => 'Keripik Singkong Pedas berkualitas tinggi dan populer di kalangan konsumen.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 28000, 'stok' => 10],
                        ['varian' => '50g', 'berat' => 50, 'harga' => 15000, 'stok' => 15],
                    ],
                    'gambar' => 'produk_image/keripik-singkong-pedas.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Keripik Pisang Manis',
                    'deskripsi' => 'Keripik pisang renyah dengan rasa manis alami.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 30000, 'stok' => 20],
                        ['varian' => '50g', 'berat' => 50, 'harga' => 16000, 'stok' => 25],
                    ],
                    'gambar' => 'produk_image/keripik-pisang-manis.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Sambal Cumi Asin',
                    'deskripsi' => 'Sambal cumi asin khas Indramayu, pedas gurih.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 45000, 'stok' => 12],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 20000, 'stok' => 18],
                    ],
                    'gambar' => 'produk_image/sambal-cumi-asin.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Batik Tulis Indramayu',
                    'deskripsi' => 'Batik tulis asli dengan motif khas pesisir.',
                    'varian' => [
                        ['varian' => 'L', 'berat' => 500, 'harga' => 150000, 'stok' => 5],
                        ['varian' => 'M', 'berat' => 450, 'harga' => 140000, 'stok' => 7],
                    ],
                    'gambar' => 'produk_image/batik-tulis-indramayu.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Kopi Robusta Lokal',
                    'deskripsi' => 'Kopi robusta hasil petani lokal dengan rasa khas.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 40000, 'stok' => 20],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 22000, 'stok' => 30],
                    ],
                    'gambar' => 'produk_image/kopi-robusta-lokal.jpg',
                    'kategori_id' => 4
                ],
                [
                    'nama_produk' => 'Madu Hutan Asli',
                    'deskripsi' => 'Madu murni dari hutan alami tanpa campuran.',
                    'varian' => [
                        ['varian' => '500ml', 'berat' => 700, 'harga' => 120000, 'stok' => 8],
                        ['varian' => '250ml', 'berat' => 350, 'harga' => 65000, 'stok' => 15],
                    ],
                    'gambar' => 'produk_image/madu-hutan-asli.jpg',
                    'kategori_id' => 4
                ],
                [
                    'nama_produk' => 'Abon Ikan Tuna',
                    'deskripsi' => 'Abon ikan tuna gurih dan lezat, cocok untuk lauk.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 50000, 'stok' => 12],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 22000, 'stok' => 18],
                    ],
                    'gambar' => 'produk_image/abon-ikan-tuna.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kerupuk Udang',
                    'deskripsi' => 'Kerupuk udang renyah dengan rasa gurih khas laut.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 28000, 'stok' => 15],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 15000, 'stok' => 25],
                    ],
                    'gambar' => 'produk_image/kerupuk-udang.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Sirup Mangga Indramayu',
                    'deskripsi' => 'Sirup segar rasa mangga khas Indramayu.',
                    'varian' => [
                        ['varian' => '600ml', 'berat' => 800, 'harga' => 35000, 'stok' => 20],
                        ['varian' => '300ml', 'berat' => 450, 'harga' => 20000, 'stok' => 25],
                    ],
                    'gambar' => 'produk_image/sirup-mangga-indramayu.jpg',
                    'kategori_id' => 4
                ],
                [
                    'nama_produk' => 'Kue Kacang',
                    'deskripsi' => 'Kue kacang manis legit khas UMKM lokal.',
                    'varian' => [
                        ['varian' => '500g', 'berat' => 500, 'harga' => 60000, 'stok' => 10],
                        ['varian' => '250g', 'berat' => 250, 'harga' => 32000, 'stok' => 18],
                    ],
                    'gambar' => 'produk_image/kue-kacang.jpg',
                    'kategori_id' => 5
                ],
                [
                    'nama_produk' => 'Keripik Talas Asin',
                    'deskripsi' => 'Keripik Talas renyah dengan rasa asin gurih yang disukai banyak orang.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 30000, 'stok' => 12],
                        ['varian' => '50g', 'berat' => 50, 'harga' => 16000, 'stok' => 18],
                    ],
                    'gambar' => 'produk_image/keripik-talas-asin.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Keripik Kentang Balado',
                    'deskripsi' => 'Keripik kentang dengan bumbu balado khas Minang yang pedas manis.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 32000, 'stok' => 14],
                        ['varian' => '50g', 'berat' => 50, 'harga' => 17000, 'stok' => 20],
                    ],
                    'gambar' => 'produk_image/keripik-kentang-balado.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kerupuk Ikan Tenggiri',
                    'deskripsi' => 'Kerupuk gurih dari ikan tenggiri segar dengan tekstur renyah.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 45000, 'stok' => 8],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 24000, 'stok' => 12],
                    ],
                    'gambar' => 'produk_image/kerupuk-ikan-tenggiri.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kerupuk Udang',
                    'deskripsi' => 'Kerupuk dengan rasa udang yang kuat dan aroma khas laut.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 40000, 'stok' => 10],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 22000, 'stok' => 16],
                    ],
                    'gambar' => 'produk_image/kerupuk-udang.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Bolu Kukus Coklat',
                    'deskripsi' => 'Bolu kukus lembut dengan rasa coklat premium.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 35000, 'stok' => 6],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 65000, 'stok' => 4],
                    ],
                    'gambar' => 'produk_image/bolu-kukus-coklat.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Bolu Kukus Pandan',
                    'deskripsi' => 'Bolu kukus harum dengan rasa pandan asli.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 34000, 'stok' => 7],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 63000, 'stok' => 5],
                    ],
                    'gambar' => 'produk_image/bolu-kukus-pandan.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Kue Lapis Legit',
                    'deskripsi' => 'Kue lapis legit khas dengan aroma rempah dan tekstur berlapis.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 75000, 'stok' => 4],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 140000, 'stok' => 3],
                    ],
                    'gambar' => 'produk_image/kue-lapis-legit.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Kue Nastar',
                    'deskripsi' => 'Kue nastar isi selai nanas manis dan lumer di mulut.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 60000, 'stok' => 8],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 110000, 'stok' => 5],
                    ],
                    'gambar' => 'produk_image/kue-nastar.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Kue Kastengel',
                    'deskripsi' => 'Kue kastengel keju gurih renyah dengan aroma khas butter.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 65000, 'stok' => 6],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 120000, 'stok' => 3],
                    ],
                    'gambar' => 'produk_image/kue-kastengel.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Kue Putri Salju',
                    'deskripsi' => 'Kue kering lembut dengan taburan gula halus.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 58000, 'stok' => 7],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 110000, 'stok' => 4],
                    ],
                    'gambar' => 'produk_image/kue-putri-salju.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Kopi Arabika Gayo',
                    'deskripsi' => 'Kopi Arabika Gayo dengan cita rasa khas Aceh.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 80000, 'stok' => 9],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 150000, 'stok' => 6],
                    ],
                    'gambar' => 'produk_image/kopi-arabika-gayo.jpg',
                    'kategori_id' => 4
                ],
                [
                    'nama_produk' => 'Kopi Robusta Lampung',
                    'deskripsi' => 'Kopi Robusta Lampung dengan rasa kuat dan pekat.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 70000, 'stok' => 8],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 130000, 'stok' => 5],
                    ],
                    'gambar' => 'produk_image/kopi-robusta-lampung.jpg',
                    'kategori_id' => 4
                ],
                [
                    'nama_produk' => 'Kopi Luwak',
                    'deskripsi' => 'Kopi eksklusif dari biji kopi yang dimakan dan dikeluarkan luwak.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 250000, 'stok' => 2],
                        ['varian' => '200g', 'berat' => 200, 'harga' => 480000, 'stok' => 1],
                    ],
                    'gambar' => 'produk_image/kopi-luwak.jpg',
                    'kategori_id' => 4
                ],
                [
                    'nama_produk' => 'Teh Hijau',
                    'deskripsi' => 'Teh hijau alami kaya antioksidan, baik untuk kesehatan.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 30000, 'stok' => 10],
                        ['varian' => '200g', 'berat' => 200, 'harga' => 55000, 'stok' => 7],
                    ],
                    'gambar' => 'produk_image/teh-hijau.jpg',
                    'kategori_id' => 5
                ],
                [
                    'nama_produk' => 'Teh Hitam',
                    'deskripsi' => 'Teh hitam pekat dengan rasa khas Nusantara.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 28000, 'stok' => 12],
                        ['varian' => '200g', 'berat' => 200, 'harga' => 50000, 'stok' => 8],
                    ],
                    'gambar' => 'produk_image/teh-hitam.jpg',
                    'kategori_id' => 5
                ],
                [
                    'nama_produk' => 'Teh Bunga Rosella',
                    'deskripsi' => 'Teh herbal dari bunga rosella segar, menyehatkan tubuh.',
                    'varian' => [
                        ['varian' => '50g', 'berat' => 50, 'harga' => 35000, 'stok' => 9],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 65000, 'stok' => 5],
                    ],
                    'gambar' => 'produk_image/teh-rosella.jpg',
                    'kategori_id' => 5
                ],
                [
                    'nama_produk' => 'Madu Hutan Asli',
                    'deskripsi' => 'Madu alami langsung dari hutan tropis Indonesia.',
                    'varian' => [
                        ['varian' => '250ml', 'berat' => 250, 'harga' => 60000, 'stok' => 7],
                        ['varian' => '500ml', 'berat' => 500, 'harga' => 110000, 'stok' => 4],
                    ],
                    'gambar' => 'produk_image/madu-hutan-asli.jpg',
                    'kategori_id' => 6
                ],
                [
                    'nama_produk' => 'Madu Klanceng',
                    'deskripsi' => 'Madu klanceng murni dengan rasa khas asam manis.',
                    'varian' => [
                        ['varian' => '250ml', 'berat' => 250, 'harga' => 85000, 'stok' => 6],
                        ['varian' => '500ml', 'berat' => 500, 'harga' => 160000, 'stok' => 3],
                    ],
                    'gambar' => 'produk_image/madu-klanceng.jpg',
                    'kategori_id' => 6
                ],
                [
                    'nama_produk' => 'Minyak Kelapa Murni',
                    'deskripsi' => 'Minyak kelapa murni (VCO) kaya manfaat untuk kesehatan.',
                    'varian' => [
                        ['varian' => '250ml', 'berat' => 250, 'harga' => 70000, 'stok' => 5],
                        ['varian' => '500ml', 'berat' => 500, 'harga' => 130000, 'stok' => 3],
                    ],
                    'gambar' => 'produk_image/minyak-kelapa.jpg',
                    'kategori_id' => 6
                ],
                [
                    'nama_produk' => 'Minyak Zaitun',
                    'deskripsi' => 'Minyak zaitun murni untuk kesehatan dan kecantikan.',
                    'varian' => [
                        ['varian' => '250ml', 'berat' => 250, 'harga' => 90000, 'stok' => 6],
                        ['varian' => '500ml', 'berat' => 500, 'harga' => 170000, 'stok' => 4],
                    ],
                    'gambar' => 'produk_image/minyak-zaitun.jpg',
                    'kategori_id' => 6
                ],
                [
                    'nama_produk' => 'Keripik Ubi Ungu',
                    'deskripsi' => 'Keripik Ubi Ungu gurih dan manis alami, cocok untuk cemilan sehat.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 25000, 'stok' => 12],
                        ['varian' => '50g', 'berat' => 50, 'harga' => 14000, 'stok' => 20],
                    ],
                    'gambar' => 'produk_image/keripik-ubi-ungu.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kerupuk Kulit Sapi',
                    'deskripsi' => 'Kerupuk kulit sapi renyah dengan cita rasa khas Nusantara.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 40000, 'stok' => 8],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 22000, 'stok' => 15],
                    ],
                    'gambar' => 'produk_image/kerupuk-kulit-sapi.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kerupuk Udang',
                    'deskripsi' => 'Kerupuk udang asli dengan aroma khas laut yang gurih.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 45000, 'stok' => 10],
                        ['varian' => '125g', 'berat' => 125, 'harga' => 24000, 'stok' => 18],
                    ],
                    'gambar' => 'produk_image/kerupuk-udang.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kerupuk Ikan',
                    'deskripsi' => 'Kerupuk ikan segar dengan tekstur renyah dan rasa gurih alami.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 35000, 'stok' => 9],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 19000, 'stok' => 14],
                    ],
                    'gambar' => 'produk_image/kerupuk-ikan.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kerupuk Rambak',
                    'deskripsi' => 'Kerupuk rambak asli dengan cita rasa gurih yang khas.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 42000, 'stok' => 10],
                        ['varian' => '125g', 'berat' => 125, 'harga' => 22000, 'stok' => 15],
                    ],
                    'gambar' => 'produk_image/kerupuk-rambak.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kerupuk Bawang',
                    'deskripsi' => 'Kerupuk bawang dengan aroma harum dan tekstur gurih renyah.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 30000, 'stok' => 12],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 17000, 'stok' => 20],
                    ],
                    'gambar' => 'produk_image/kerupuk-bawang.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kacang Atom',
                    'deskripsi' => 'Kacang atom gurih dengan balutan tepung renyah.',
                    'varian' => [
                        ['varian' => '150g', 'berat' => 150, 'harga' => 25000, 'stok' => 18],
                        ['varian' => '75g', 'berat' => 75, 'harga' => 14000, 'stok' => 22],
                    ],
                    'gambar' => 'produk_image/kacang-atom.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kacang Garing',
                    'deskripsi' => 'Kacang tanah goreng dengan rasa gurih renyah.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 32000, 'stok' => 10],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 18000, 'stok' => 16],
                    ],
                    'gambar' => 'produk_image/kacang-garing.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kacang Telur',
                    'deskripsi' => 'Kacang tanah dilapisi telur dengan rasa manis gurih.',
                    'varian' => [
                        ['varian' => '150g', 'berat' => 150, 'harga' => 28000, 'stok' => 12],
                        ['varian' => '75g', 'berat' => 75, 'harga' => 15000, 'stok' => 20],
                    ],
                    'gambar' => 'produk_image/kacang-telur.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kacang Mede',
                    'deskripsi' => 'Kacang mede premium dengan cita rasa gurih alami.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 55000, 'stok' => 6],
                        ['varian' => '50g', 'berat' => 50, 'harga' => 29000, 'stok' => 10],
                    ],
                    'gambar' => 'produk_image/kacang-mede.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kacang Koro',
                    'deskripsi' => 'Kacang koro gurih renyah dengan rasa khas tradisional.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 35000, 'stok' => 11],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 19000, 'stok' => 17],
                    ],
                    'gambar' => 'produk_image/kacang-koro.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kacang Kapri',
                    'deskripsi' => 'Kacang kapri renyah dengan cita rasa gurih nikmat.',
                    'varian' => [
                        ['varian' => '150g', 'berat' => 150, 'harga' => 27000, 'stok' => 13],
                        ['varian' => '75g', 'berat' => 75, 'harga' => 15000, 'stok' => 19],
                    ],
                    'gambar' => 'produk_image/kacang-kapri.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kacang Polong',
                    'deskripsi' => 'Kacang polong gurih dan kaya nutrisi.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 34000, 'stok' => 10],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 19000, 'stok' => 14],
                    ],
                    'gambar' => 'produk_image/kacang-polong.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kacang Garuda',
                    'deskripsi' => 'Kacang tanah pilihan dengan rasa gurih dan renyah.',
                    'varian' => [
                        ['varian' => '150g', 'berat' => 150, 'harga' => 26000, 'stok' => 15],
                        ['varian' => '75g', 'berat' => 75, 'harga' => 14000, 'stok' => 22],
                    ],
                    'gambar' => 'produk_image/kacang-garuda.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kacang Oven',
                    'deskripsi' => 'Kacang oven tanpa minyak dengan rasa gurih sehat.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 27000, 'stok' => 12],
                        ['varian' => '50g', 'berat' => 50, 'harga' => 15000, 'stok' => 20],
                    ],
                    'gambar' => 'produk_image/kacang-oven.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kacang Sangrai',
                    'deskripsi' => 'Kacang tanah sangrai dengan rasa gurih khas tradisional.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 30000, 'stok' => 14],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 17000, 'stok' => 21],
                    ],
                    'gambar' => 'produk_image/kacang-sangrai.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kacang Kedelai',
                    'deskripsi' => 'Kacang kedelai gurih cocok untuk camilan sehat.',
                    'varian' => [
                        ['varian' => '150g', 'berat' => 150, 'harga' => 24000, 'stok' => 16],
                        ['varian' => '75g', 'berat' => 75, 'harga' => 13000, 'stok' => 24],
                    ],
                    'gambar' => 'produk_image/kacang-kedelai.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kacang Almond',
                    'deskripsi' => 'Kacang almond impor dengan rasa gurih dan tekstur renyah.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 70000, 'stok' => 5],
                        ['varian' => '50g', 'berat' => 50, 'harga' => 37000, 'stok' => 8],
                    ],
                    'gambar' => 'produk_image/kacang-almond.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kacang Pistachio',
                    'deskripsi' => 'Kacang pistachio dengan rasa gurih lezat.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 80000, 'stok' => 4],
                        ['varian' => '50g', 'berat' => 50, 'harga' => 42000, 'stok' => 7],
                    ],
                    'gambar' => 'produk_image/kacang-pistachio.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Keripik Bayam Renyah',
                    'deskripsi' => 'Keripik bayam renyah dengan rasa gurih alami.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 23000, 'stok' => 10],
                        ['varian' => '50g', 'berat' => 50, 'harga' => 12000, 'stok' => 20],
                    ],
                    'gambar' => 'produk_image/keripik-bayam-renyah.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Bolu Kukus Pandan',
                    'deskripsi' => 'Bolu kukus pandan yang lembut dan harum pandan.',
                    'varian' => [
                        ['varian' => '500g', 'berat' => 500, 'harga' => 45000, 'stok' => 8],
                        ['varian' => '250g', 'berat' => 250, 'harga' => 25000, 'stok' => 12],
                    ],
                    'gambar' => 'produk_image/bolu-kukus-pandan.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kue Kering Coklat',
                    'deskripsi' => 'Kue kering coklat dengan rasa manis legit.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 40000, 'stok' => 10],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 18000, 'stok' => 18],
                    ],
                    'gambar' => 'produk_image/kue-kering-coklat.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kerupuk Bawang',
                    'deskripsi' => 'Kerupuk bawang renyah dan gurih.',
                    'varian' => [
                        ['varian' => '500g', 'berat' => 500, 'harga' => 28000, 'stok' => 12],
                        ['varian' => '250g', 'berat' => 250, 'harga' => 15000, 'stok' => 18],
                    ],
                    'gambar' => 'produk_image/kerupuk-bawang.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Brem Tape Ketan',
                    'deskripsi' => 'Brem tape ketan manis dengan rasa khas.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 30000, 'stok' => 10],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 16000, 'stok' => 15],
                    ],
                    'gambar' => 'produk_image/brem-tape-ketan.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Dodol Garut',
                    'deskripsi' => 'Dodol garut legit dan kenyal, cocok untuk oleh-oleh.',
                    'varian' => [
                        ['varian' => '500g', 'berat' => 500, 'harga' => 50000, 'stok' => 10],
                        ['varian' => '250g', 'berat' => 250, 'harga' => 27000, 'stok' => 14],
                    ],
                    'gambar' => 'produk_image/dodol-garut.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Keripik Pisang Sale',
                    'deskripsi' => 'Keripik pisang sale manis dan gurih.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 25000, 'stok' => 12],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 14000, 'stok' => 20],
                    ],
                    'gambar' => 'produk_image/keripik-pisang-sale.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kue Cubit Coklat',
                    'deskripsi' => 'Kue cubit coklat lembut dan manis.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 22000, 'stok' => 10],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 12000, 'stok' => 15],
                    ],
                    'gambar' => 'produk_image/kue-cubit-coklat.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Sagon Kelapa',
                    'deskripsi' => 'Kue tradisional sagon kelapa manis gurih.',
                    'varian' => [
                        ['varian' => '300g', 'berat' => 300, 'harga' => 35000, 'stok' => 8],
                        ['varian' => '150g', 'berat' => 150, 'harga' => 19000, 'stok' => 12],
                    ],
                    'gambar' => 'produk_image/sagon-kelapa.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Rengginang',
                    'deskripsi' => 'Rengginang gurih renyah khas tradisional.',
                    'varian' => [
                        ['varian' => '500g', 'berat' => 500, 'harga' => 26000, 'stok' => 15],
                        ['varian' => '250g', 'berat' => 250, 'harga' => 14000, 'stok' => 20],
                    ],
                    'gambar' => 'produk_image/rengginang.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kue Lumpur Kentang',
                    'deskripsi' => 'Kue lumpur kentang dengan tekstur lembut.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 20000, 'stok' => 12],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 11000, 'stok' => 18],
                    ],
                    'gambar' => 'produk_image/kue-lumpur-kentang.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Keripik Pare',
                    'deskripsi' => 'Keripik pare unik dengan rasa khas gurih.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 22000, 'stok' => 10],
                        ['varian' => '50g', 'berat' => 50, 'harga' => 12000, 'stok' => 20],
                    ],
                    'gambar' => 'produk_image/keripik-pare.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Getuk Lindri',
                    'deskripsi' => 'Getuk lindri tradisional dengan taburan kelapa.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 23000, 'stok' => 12],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 13000, 'stok' => 18],
                    ],
                    'gambar' => 'produk_image/getuk-lindri.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Wajik Ketan',
                    'deskripsi' => 'Wajik ketan manis legit khas Jawa.',
                    'varian' => [
                        ['varian' => '300g', 'berat' => 300, 'harga' => 28000, 'stok' => 8],
                        ['varian' => '150g', 'berat' => 150, 'harga' => 16000, 'stok' => 15],
                    ],
                    'gambar' => 'produk_image/wajik-ketan.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Kue Kacang Tanah',
                    'deskripsi' => 'Kue kering kacang tanah manis gurih.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 33000, 'stok' => 10],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 17000, 'stok' => 20],
                    ],
                    'gambar' => 'produk_image/kue-kacang-tanah.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Opak Singkong',
                    'deskripsi' => 'Opak singkong renyah khas pedesaan.',
                    'varian' => [
                        ['varian' => '500g', 'berat' => 500, 'harga' => 25000, 'stok' => 12],
                        ['varian' => '250g', 'berat' => 250, 'harga' => 14000, 'stok' => 18],
                    ],
                    'gambar' => 'produk_image/opak-singkong.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Onde-Onde Wijen',
                    'deskripsi' => 'Onde-onde isi kacang hijau dengan taburan wijen.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 25000, 'stok' => 12],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 14000, 'stok' => 20],
                    ],
                    'gambar' => 'produk_image/onde-onde-wijen.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kerupuk Udang',
                    'deskripsi' => 'Kerupuk udang gurih dengan aroma khas laut.',
                    'varian' => [
                        ['varian' => '500g', 'berat' => 500, 'harga' => 45000, 'stok' => 8],
                        ['varian' => '250g', 'berat' => 250, 'harga' => 24000, 'stok' => 14],
                    ],
                    'gambar' => 'produk_image/kerupuk-udang.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kue Apem Tradisional',
                    'deskripsi' => 'Kue apem empuk dengan rasa manis tradisional.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 20000, 'stok' => 10],
                        ['varian' => '100g', 'berat' => 100, 'harga' => 12000, 'stok' => 15],
                    ],
                    'gambar' => 'produk_image/kue-apem-tradisional.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Keripik Singkong Rasa Jagung Bakar',
                    'deskripsi' => 'Keripik singkong dengan rasa jagung bakar yang gurih dan harum.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 23000, 'stok' => 12],
                        ['varian' => '50g', 'berat' => 50, 'harga' => 12000, 'stok' => 18],
                    ],
                    'gambar' => 'produk_image/keripik-singkong-jagung.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kue Kering Keju',
                    'deskripsi' => 'Kue kering dengan taburan keju yang lezat, cocok untuk camilan santai.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 45000, 'stok' => 9],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 85000, 'stok' => 6],
                    ],
                    'gambar' => 'produk_image/kue-kering-keju.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kerupuk Udang Renyah',
                    'deskripsi' => 'Kerupuk udang khas Indramayu yang gurih dan renyah.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 27000, 'stok' => 10],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 60000, 'stok' => 8],
                    ],
                    'gambar' => 'produk_image/kerupuk-udang.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Opak Singkong',
                    'deskripsi' => 'Opak singkong gurih yang digoreng hingga renyah.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 22000, 'stok' => 15],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 40000, 'stok' => 12],
                    ],
                    'gambar' => 'produk_image/opak-singkong.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Sale Pisang Kering',
                    'deskripsi' => 'Sale pisang kering khas Indramayu dengan rasa manis alami.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 25000, 'stok' => 12],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 55000, 'stok' => 8],
                    ],
                    'gambar' => 'produk_image/sale-pisang.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kue Klepon Kering',
                    'deskripsi' => 'Inovasi klepon kering dengan rasa manis dan gurih kelapa.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 30000, 'stok' => 9],
                        ['varian' => '400g', 'berat' => 400, 'harga' => 55000, 'stok' => 6],
                    ],
                    'gambar' => 'produk_image/klepon-kering.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kue Nastar Premium',
                    'deskripsi' => 'Kue nastar isi selai nanas dengan rasa manis dan lembut.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 50000, 'stok' => 7],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 90000, 'stok' => 5],
                    ],
                    'gambar' => 'produk_image/nastar-premium.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Manisan Mangga Indramayu',
                    'deskripsi' => 'Manisan mangga khas Indramayu dengan rasa manis dan asam segar.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 28000, 'stok' => 12],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 60000, 'stok' => 9],
                    ],
                    'gambar' => 'produk_image/manisan-mangga.jpg',
                    'kategori_id' => 4
                ],
                [
                    'nama_produk' => 'Kue Putri Salju',
                    'deskripsi' => 'Kue kering dengan taburan gula halus yang lembut di mulut.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 48000, 'stok' => 10],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 90000, 'stok' => 7],
                    ],
                    'gambar' => 'produk_image/putri-salju.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kerupuk Kulit Ikan',
                    'deskripsi' => 'Kerupuk kulit ikan yang gurih, cocok untuk camilan sehat.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 30000, 'stok' => 8],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 70000, 'stok' => 6],
                    ],
                    'gambar' => 'produk_image/kerupuk-ikan.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Kue Brownies Kukus',
                    'deskripsi' => 'Brownies kukus cokelat dengan tekstur lembut dan rasa manis pas.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 55000, 'stok' => 6],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 100000, 'stok' => 4],
                    ],
                    'gambar' => 'produk_image/brownies-kukus.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Keripik Tempe Gurih',
                    'deskripsi' => 'Keripik tempe renyah dengan rasa gurih khas tradisional.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 18000, 'stok' => 14],
                        ['varian' => '200g', 'berat' => 200, 'harga' => 35000, 'stok' => 9],
                    ],
                    'gambar' => 'produk_image/keripik-tempe.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kue Kering Sagu Keju',
                    'deskripsi' => 'Kue sagu keju dengan tekstur renyah dan rasa keju yang gurih.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 48000, 'stok' => 10],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 90000, 'stok' => 7],
                    ],
                    'gambar' => 'produk_image/sagu-keju.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Manisan Salak',
                    'deskripsi' => 'Manisan salak segar dengan rasa manis asam khas.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 28000, 'stok' => 12],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 60000, 'stok' => 9],
                    ],
                    'gambar' => 'produk_image/manisan-salak.jpg',
                    'kategori_id' => 4
                ],
                [
                    'nama_produk' => 'Kerupuk Jangek (Kerupuk Kulit Sapi)',
                    'deskripsi' => 'Kerupuk kulit sapi khas dengan rasa gurih renyah.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 35000, 'stok' => 8],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 80000, 'stok' => 5],
                    ],
                    'gambar' => 'produk_image/kerupuk-jangek.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Kue Kastengel',
                    'deskripsi' => 'Kue kering kastengel dengan rasa keju gurih, cocok untuk lebaran.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 55000, 'stok' => 6],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 100000, 'stok' => 4],
                    ],
                    'gambar' => 'produk_image/kastengel.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Keripik Balado Pedas',
                    'deskripsi' => 'Keripik singkong dengan bumbu balado pedas yang khas.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 20000, 'stok' => 13],
                        ['varian' => '200g', 'berat' => 200, 'harga' => 38000, 'stok' => 9],
                    ],
                    'gambar' => 'produk_image/keripik-balado.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Kue Bolen Pisang',
                    'deskripsi' => 'Kue bolen pisang dengan isian cokelat dan keju.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 60000, 'stok' => 6],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 110000, 'stok' => 4],
                    ],
                    'gambar' => 'produk_image/bolen-pisang.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Manisan Kedondong',
                    'deskripsi' => 'Manisan kedondong dengan rasa asam segar berpadu manis.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 27000, 'stok' => 11],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 58000, 'stok' => 7],
                    ],
                    'gambar' => 'produk_image/manisan-kedondong.jpg',
                    'kategori_id' => 4
                ],
                [
                    'nama_produk' => 'Kerupuk Aci Pedas',
                    'deskripsi' => 'Kerupuk aci dengan bumbu pedas khas Indramayu.',
                    'varian' => [
                        ['varian' => '200g', 'berat' => 200, 'harga' => 25000, 'stok' => 13],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 50000, 'stok' => 9],
                    ],
                    'gambar' => 'produk_image/kerupuk-aci-pedas.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Camilan Rengginang Ketan',
                    'deskripsi' => 'Rengginang ketan khas dengan rasa gurih renyah.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 12000, 'stok' => 25],
                        ['varian' => '250g', 'berat' => 250, 'harga' => 28000, 'stok' => 15],
                    ],
                    'gambar' => 'produk_image/rengginang-ketan.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kerupuk Udang Asli',
                    'deskripsi' => 'Kerupuk udang dengan rasa asli laut Indonesia.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 15000, 'stok' => 20],
                        ['varian' => '200g', 'berat' => 200, 'harga' => 28000, 'stok' => 10],
                    ],
                    'gambar' => 'produk_image/kerupuk-udang.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Bolu Kukus Gula Merah',
                    'deskripsi' => 'Bolu kukus lembut dengan aroma gula merah.',
                    'varian' => [
                        ['varian' => '1 pcs', 'berat' => 80, 'harga' => 8000, 'stok' => 30],
                        ['varian' => 'Pack isi 5', 'berat' => 400, 'harga' => 35000, 'stok' => 10],
                    ],
                    'gambar' => 'produk_image/bolu-kukus-gula-merah.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Onde-Onde Wijen',
                    'deskripsi' => 'Onde-onde dengan isi kacang hijau legit.',
                    'varian' => [
                        ['varian' => '1 pcs', 'berat' => 50, 'harga' => 5000, 'stok' => 40],
                        ['varian' => 'Pack isi 6', 'berat' => 300, 'harga' => 28000, 'stok' => 10],
                    ],
                    'gambar' => 'produk_image/onde-onde.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Kue Kering Nastar',
                    'deskripsi' => 'Nastar isi selai nanas manis legit.',
                    'varian' => [
                        ['varian' => '250g', 'berat' => 250, 'harga' => 45000, 'stok' => 15],
                        ['varian' => '500g', 'berat' => 500, 'harga' => 85000, 'stok' => 8],
                    ],
                    'gambar' => 'produk_image/nastar.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Lemper Ayam',
                    'deskripsi' => 'Lemper isi ayam suwir gurih khas nusantara.',
                    'varian' => [
                        ['varian' => '1 pcs', 'berat' => 60, 'harga' => 7000, 'stok' => 25],
                        ['varian' => 'Pack isi 5', 'berat' => 300, 'harga' => 32000, 'stok' => 12],
                    ],
                    'gambar' => 'produk_image/lemper-ayam.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Serabi Kuah Kinca',
                    'deskripsi' => 'Serabi lembut disajikan dengan kuah kinca manis.',
                    'varian' => [
                        ['varian' => '1 pcs', 'berat' => 70, 'harga' => 6000, 'stok' => 30],
                        ['varian' => 'Pack isi 5', 'berat' => 350, 'harga' => 28000, 'stok' => 12],
                    ],
                    'gambar' => 'produk_image/serabi-kinca.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Kue Cubit Cokelat',
                    'deskripsi' => 'Kue cubit lembut dengan topping cokelat lumer.',
                    'varian' => [
                        ['varian' => '1 pcs', 'berat' => 50, 'harga' => 5000, 'stok' => 35],
                        ['varian' => 'Pack isi 6', 'berat' => 300, 'harga' => 28000, 'stok' => 10],
                    ],
                    'gambar' => 'produk_image/kue-cubit.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Peyek Kacang Renyah',
                    'deskripsi' => 'Peyek kacang gurih, cocok untuk cemilan dan lauk.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 12000, 'stok' => 20],
                        ['varian' => '200g', 'berat' => 200, 'harga' => 22000, 'stok' => 12],
                    ],
                    'gambar' => 'produk_image/peyek-kacang.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Emping Melinjo',
                    'deskripsi' => 'Emping melinjo asli dengan rasa gurih pahit khas.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 15000, 'stok' => 20],
                        ['varian' => '200g', 'berat' => 200, 'harga' => 28000, 'stok' => 10],
                    ],
                    'gambar' => 'produk_image/emping-melinjo.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Kerupuk Bawang',
                    'deskripsi' => 'Kerupuk bawang renyah dengan aroma bawang gurih.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 12000, 'stok' => 30],
                        ['varian' => '200g', 'berat' => 200, 'harga' => 22000, 'stok' => 15],
                    ],
                    'gambar' => 'produk_image/kerupuk-bawang.jpg',
                    'kategori_id' => 2
                ],
                [
                    'nama_produk' => 'Dodol Susu',
                    'deskripsi' => 'Dodol susu legit khas daerah pedesaan.',
                    'varian' => [
                        ['varian' => '100g', 'berat' => 100, 'harga' => 18000, 'stok' => 20],
                        ['varian' => '200g', 'berat' => 200, 'harga' => 32000, 'stok' => 10],
                    ],
                    'gambar' => 'produk_image/dodol-susu.jpg',
                    'kategori_id' => 1
                ],
                [
                    'nama_produk' => 'Wingko Babat',
                    'deskripsi' => 'Wingko babat manis gurih khas tradisional.',
                    'varian' => [
                        ['varian' => '1 pcs', 'berat' => 80, 'harga' => 8000, 'stok' => 30],
                        ['varian' => 'Pack isi 6', 'berat' => 480, 'harga' => 45000, 'stok' => 12],
                    ],
                    'gambar' => 'produk_image/wingko-babat.jpg',
                    'kategori_id' => 3
                ],
                [
                    'nama_produk' => 'Tahu Sumedang',
                    'deskripsi' => 'Tahu khas Sumedang dengan tekstur renyah di luar lembut di dalam.',
                    'varian' => [
                        ['varian' => 'Pack isi 10', 'berat' => 400, 'harga' => 25000, 'stok' => 20],
                        ['varian' => 'Pack isi 20', 'berat' => 800, 'harga' => 48000, 'stok' => 10],
                    ],
                    'gambar' => 'produk_image/tahu-sumedang.jpg',
                    'kategori_id' => 4
                ],
                [
                    'nama_produk' => 'Tempe Mendoan',
                    'deskripsi' => 'Tempe mendoan khas Banyumas, gurih dan nikmat.',
                    'varian' => [
                        ['varian' => 'Pack isi 5', 'berat' => 250, 'harga' => 15000, 'stok' => 20],
                        ['varian' => 'Pack isi 10', 'berat' => 500, 'harga' => 28000, 'stok' => 10],
                    ],
                    'gambar' => 'produk_image/tempe-mendoan.jpg',
                    'kategori_id' => 4
                ],
                [
                    'nama_produk' => 'Sate Ayam Madura',
                    'deskripsi' => 'Sate ayam Madura lengkap dengan bumbu kacang.',
                    'varian' => [
                        ['varian' => '10 tusuk', 'berat' => 250, 'harga' => 35000, 'stok' => 15],
                        ['varian' => '20 tusuk', 'berat' => 500, 'harga' => 65000, 'stok' => 8],
                    ],
                    'gambar' => 'produk_image/sate-ayam-madura.jpg',
                    'kategori_id' => 4
                ],
                [
                    'nama_produk' => 'Rawon Daging Sapi',
                    'deskripsi' => 'Rawon khas Jawa Timur dengan daging sapi pilihan.',
                    'varian' => [
                        ['varian' => '1 porsi', 'berat' => 400, 'harga' => 45000, 'stok' => 20],
                        ['varian' => '2 porsi', 'berat' => 800, 'harga' => 85000, 'stok' => 10],
                    ],
                    'gambar' => 'produk_image/rawon-sapi.jpg',
                    'kategori_id' => 4
                ],
                [
                    'nama_produk' => 'Soto Ayam Lamongan',
                    'deskripsi' => 'Soto ayam khas Lamongan segar dengan koya.',
                    'varian' => [
                        ['varian' => '1 porsi', 'berat' => 350, 'harga' => 30000, 'stok' => 20],
                        ['varian' => '2 porsi', 'berat' => 700, 'harga' => 58000, 'stok' => 10],
                    ],
                    'gambar' => 'produk_image/soto-lamongan.jpg',
                    'kategori_id' => 4
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
