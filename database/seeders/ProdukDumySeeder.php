<?php

 namespace Database\Seeders;

 use Illuminate\Database\Console\Seeds\WithoutModelEvents;
 use Illuminate\Database\Seeder;

 use App\Models\MemberDumy;
 use App\Models\ProdukDumy;
 use App\Models\ProdukVarianDumy;
 use App\Models\ProdukFotoDumy;
use App\Models\KeranjangKuDumy;
use Faker\Factory as Faker;


 class ProdukDumySeeder extends Seeder
 {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
  $faker = Faker::create('id_ID');

  // Seed MemberDumy
  for ($i = 0; $i < 2; $i++) {
  MemberDumy::create([
  'nama' => $faker->name,
  ]);
  }

  // Seed ProdukDumy
  MemberDumy::all()->each(function ($member) use ($faker) {
  for ($i = 0; $i < 10; $i++) {
  ProdukDumy::create([
  'nama_produk' => $faker->sentence(3),
  'deskripsi' => $faker->paragraph(2),
  'member_id' => $member->id,
  ]);
  }
  });

  // Seed ProdukVarianDumy
  ProdukDumy::all()->each(function ($produk) use ($faker) {
  for ($i = 0; $i < 3; $i++) {
  ProdukVarianDumy::create([
  'nama_varian' => $faker->word . ' ' . $faker->randomElement(['S', 'M', 'L', 'XL']),
  'harga' => $faker->numberBetween(10000, 100000),
  'stok' => $faker->numberBetween(10, 100),
  'produk_id' => $produk->id,
  ]);
  }
  });

  // Seed ProdukFotoDumy
  ProdukDumy::all()->each(function ($produk) use ($faker) {
  $jumlahFoto = $faker->numberBetween(1, 5); // Setiap produk akan memiliki 1 hingga 5 foto
  for ($i = 0; $i < $jumlahFoto; $i++) {
  ProdukFotoDumy::create([
  'foto_url' => 'https://picsum.photos/600/400', // Menghasilkan URL gambar palsu
  'produk_id' => $produk->id,
  ]);
  }
  });

  // Seed Keranjang
  ProdukVarianDumy::all()->each(function ($varian) use ($faker) {
  // Setiap varian akan dimasukkan ke keranjang beberapa kali oleh member yang berbeda
  MemberDumy::all()->each(function ($member) use ($faker, $varian) {
  if ($faker->boolean(70)) { // Peluang 70% member memasukkan varian ke keranjang
  KeranjangKuDumy::create([
  'varian_id' => $varian->id,
  'jumlah' => $faker->numberBetween(1, 5),
  'user_id' => $faker->numberBetween(1, 20),
    'member_id' => $member->id,
  // Jika ada kolom lain di tabel keranjang, Anda bisa mengisinya di sini
  // Contoh: 'member_id' => $member->id,
  ]);
  }
  });
  });
  }
 }