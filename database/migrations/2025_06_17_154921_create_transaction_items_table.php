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
    Schema::create('transaction_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
        $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
        $table->string('vehicle_title');
        $table->unsignedBigInteger('price');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
