// database/migrations/YYYY_MM_DD_HHMMSS_create_vehicles_table.php
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang posting
            $table->string('title');
            $table->string('brand'); // Merk
            $table->string('model'); // Model
            $table->integer('year'); // Tahun
            $table->decimal('price', 15, 2); // Harga
            $table->text('description');
            $table->string('image')->nullable(); // Path ke gambar utama
            $table->boolean('is_published')->default(true);
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};