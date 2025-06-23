<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- TAMBAHKAN BARIS INI
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory; // Sekarang baris ini akan berfungsi

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'vehicle_id',
        'vehicle_title',
        'price',
    ];
}
