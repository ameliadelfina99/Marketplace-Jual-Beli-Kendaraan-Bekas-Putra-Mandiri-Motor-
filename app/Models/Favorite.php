<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
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
     * Setiap item favorit "milik" satu kendaraan (vehicle).
     * Ini adalah bagian yang hilang dan menyebabkan error.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
