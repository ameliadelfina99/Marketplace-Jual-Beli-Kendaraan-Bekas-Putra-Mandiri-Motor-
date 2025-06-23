<?php

namespace Database\Seeders;
// database/seeders/BrandSeeder.php

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand; // Import model Brand
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Brand::truncate(); // Hati-hati jika ada foreign key constraint aktif

        $brands = [
            // Mobil
            ['name' => 'Toyota'],
            ['name' => 'Honda (Mobil)'], // Bedakan dengan Honda Motor jika perlu
            ['name' => 'Suzuki (Mobil)'],
            ['name' => 'Mitsubishi Motors'],
            ['name' => 'Daihatsu'],
            ['name' => 'Mazda'],
            ['name' => 'Nissan'],
            ['name' => 'BMW'],
            ['name' => 'Mercedes-Benz'],
            ['name' => 'Hyundai'],
            ['name' => 'Wuling'],
            // Motor
            ['name' => 'Honda (Motor)'],
            ['name' => 'Yamaha'],
            ['name' => 'Suzuki (Motor)'],
            ['name' => 'Kawasaki'],
            ['name' => 'Vespa'],
            // Truk/Bus
            ['name' => 'Hino'],
            ['name' => 'Isuzu'],
            ['name' => 'Mitsubishi Fuso'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand); // Model akan otomatis generate slug
        }
    }
}
