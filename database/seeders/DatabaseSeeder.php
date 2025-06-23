<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // Panggil seeder yang sudah kita buat:
        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
            // Anda bisa menambahkan seeder lain di sini jika ada
        ]);

        // Contoh jika ingin membuat user dummy juga:
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}