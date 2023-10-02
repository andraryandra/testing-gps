<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class OfficialStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create('id_ID'); // Menggunakan bahasa Indonesia

        // Ambil semua data kategori yang telah Anda buat dengan CategorySeeder
        $categories = DB::table('categories')->pluck('id');

        $chunkSize = 10; // Jumlah data yang dimasukkan per chunk

        foreach (range(1, 100) as $index) {
            $category_id = $faker->randomElement($categories);

            $data = [];

            for ($i = 0; $i < $chunkSize; $i++) {
                $data[] = [
                    'id' => $faker->uuid, // Menghasilkan id acak
                    'category_id' => $category_id,
                    'name' => $faker->company,
                    'status' => $faker->randomElement(['ACTIVE', 'INACTIVE']),
                    'phone' => $faker->numerify('08##########'), // Nomor telepon dengan 10 sampai 13 digit
                    'email' => $faker->unique()->safeEmail,
                    'city' => $faker->city,
                    'province' => $faker->state,
                    'address' => $faker->address,
                    'postal_code' => $faker->postcode,
                    'latitude' => $faker->latitude,
                    'longitude' => $faker->longitude,
                    'slug' => $faker->slug,
                    'description' => $faker->sentence,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('official_stores')->insert($data);
        }
    }
}
