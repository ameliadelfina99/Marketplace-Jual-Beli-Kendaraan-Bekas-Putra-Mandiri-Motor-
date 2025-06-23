<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- TAMBAHKAN BARIS INI
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory; // Sekarang baris ini akan berfungsi

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'invoice_number',
        'total_amount',
        'status',
    ];

    /**
     * Get the items for the transaction.
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
