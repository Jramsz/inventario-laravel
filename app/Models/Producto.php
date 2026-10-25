<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = ['sku', 'nombre', 'categoria', 'precio', 'stock', 'descripcion'];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function getValorInventarioAttribute(): float
    {
        return (float) $this->precio * $this->stock;
    }
}
