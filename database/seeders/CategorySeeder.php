<?php

namespace Database\Seeders;
// database/seeders/CategorySeeder.php

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; // Import model Category
use Illuminate\Support\Facades\DB; // Jika ingin menggunakan DB facade

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama agar tidak duplikat jika seeder dijalankan ulang (opsional)
        // Category::truncate(); // Hati-hati jika ada foreign key constraint aktif

        $categories = [
            ['name' => 'Mobil Penumpang'],
            ['name' => 'Motor'],
            ['name' => 'Truk'],
            ['name' => 'Bus'],
            ['name' => 'Kendaraan Niaga Ringan'], // Misalnya Pick-up, Van
        ];

        foreach ($categories as $category) {
            Category::create($category); // Model akan otomatis generate slug
        }

        // Atau jika ingin menggunakan DB facade (slug harus dibuat manual atau di-trigger oleh model event jika ada)
        // DB::table('categories')->insert([
        //     ['name' => 'Mobil Penumpang', 'slug' => 'mobil-penumpang', 'created_at' => now(), 'updated_at' => now()],
        //     ['name' => 'Motor', 'slug' => 'motor', 'created_at' => now(), 'updated_at' => now()],
        //     // ...dst
        // ]);
    }
}