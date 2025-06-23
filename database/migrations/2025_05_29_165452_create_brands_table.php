// database/migrations/YYYY_MM_DD_HHMMSS_create_brands_table.php
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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama merk, unik (misal: Toyota, Honda)
            $table->string('slug')->unique(); // Untuk URL (misal: toyota, honda)
            // Opsional: Anda bisa menambahkan foreign key ke categories jika satu brand hanya untuk satu kategori
            // $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};