<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'quantity',
        'category_id',
        'location_id'
    ];

    // Relación con categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación con ubicación
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // Relación con movimientos
    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
