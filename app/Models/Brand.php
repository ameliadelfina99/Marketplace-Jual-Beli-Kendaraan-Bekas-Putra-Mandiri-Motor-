<?php

namespace App\Models;
// app/Models/Brand.php


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    // boot method untuk slug otomatis (dari sebelumnya)
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name);
            }
        });
        static::updating(function ($brand) {
            if ($brand->isDirty('name') && empty($brand->slug_is_being_set_manually)) {
                $brand->slug = Str::slug($brand->name);
            }
        });
    }

    /**
     * Mendapatkan semua kendaraan yang termasuk dalam merk ini.
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}