// database/migrations/YYYY_MM_DD_HHMMSS_create_categories_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primary key, auto-increment
            $table->string('name')->unique(); // Nama kategori, unik (misal: Mobil, Motor)
            $table->string('slug')->unique(); // Untuk URL yang SEO-friendly (misal: mobil, motor)
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};