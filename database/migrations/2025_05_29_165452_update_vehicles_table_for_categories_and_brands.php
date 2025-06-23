// database/migrations/YYYY_MM_DD_HHMMSS_update_vehicles_table_for_categories_and_brands.php
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
        Schema::table('vehicles', function (Blueprint $table) {
            // Tambahkan category_id setelah user_id
            // onDelete('set null') berarti jika kategori dihapus, category_id di vehicle jadi NULL
            // nullable() berarti kolom ini boleh kosong (opsional)
            $table->foreignId('category_id')
                  ->nullable()
                  ->after('user_id') // Atur posisi kolom
                  ->constrained('categories') // Nama tabel foreign key
                  ->onDelete('set null');

            // Tambahkan brand_id setelah category_id
            $table->foreignId('brand_id')
                  ->nullable()
                  ->after('category_id') // Atur posisi kolom
                  ->constrained('brands')   // Nama tabel foreign key
                  ->onDelete('set null');

            // Hapus kolom 'brand' yang lama (yang tipenya string)
            $table->dropColumn('brand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Hapus foreign key dan kolom category_id
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');

            // Hapus foreign key dan kolom brand_id
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');

            // Tambahkan kembali kolom 'brand' yang lama
            // Sesuaikan posisi 'after' jika perlu, atau hapus jika tidak terlalu penting urutannya.
            // Pastikan ini konsisten dengan struktur awal tabel vehicles Anda.
            // Jika kolom brand sebelumnya tidak ada 'after', Anda bisa menghapusnya.
            // Saya asumsikan ada kolom 'model' sebelumnya.
            $table->string('brand')->after('model')->nullable(); // Tambahkan nullable jika sebelumnya juga nullable
        });
    }
};