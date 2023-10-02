<?php

namespace Database\Seeders;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan bahasa Indonesia

        $totalUsers = 100; // Jumlah pengguna yang ingin Anda buat
        $chunkSize = 10; // Jumlah pengguna yang dimasukkan per chunk

        for ($i = 0; $i < ceil($totalUsers / $chunkSize); $i++) {
            $usersData = [];

            for ($j = 0; $j < $chunkSize; $j++) {
                $uuid = Uuid::uuid4()->toString(); // Generate a new UUID
                $password = Hash::make('password'); // Securely hash the password

                $usersData[] = [
                    'id' => $uuid,
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'password' => $password,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('users')->insert($usersData);
        }
    }
}
