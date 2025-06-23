<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'vehicle_id',
    ];

    /**
     * Mendefinisikan relasi ke model Vehicle.
     * Setiap item keranjang (cart) "milik" satu kendaraan (vehicle).
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}