<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
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
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug_is_being_set_manually)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Mendapatkan semua kendaraan yang termasuk dalam kategori ini.
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}