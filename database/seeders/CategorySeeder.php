<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create('id_ID'); // Menggunakan bahasa Indonesia

        // Data contoh untuk tabel categories
        $categories = [
            ['name' => 'Elektronik', 'detail' => 'Kategori produk elektronik'],
            ['name' => 'Pakaian', 'detail' => 'Kategori pakaian dan fashion'],
            ['name' => 'Makanan', 'detail' => 'Kategori makanan dan minuman'],
            ['name' => 'Otomotif', 'detail' => 'Kategori produk otomotif'],
            ['name' => 'Kesehatan', 'detail' => 'Kategori produk kesehatan'],
        ];

        // Isi tabel categories dengan data kategori
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'detail' => $category['detail'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Contoh menambahkan data kategori acak
        for ($i = 0; $i < 5; $i++) {
            DB::table('categories')->insert([
                'name' => $faker->word, // Menghasilkan nama kategori acak
                'detail' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
