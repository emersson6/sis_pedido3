<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue la convención de nombres de Laravel
    protected $table = 'productos';

    // Especifica los campos que pueden ser asignados masivamente
    protected $fillable = [
        'codigo_sku',
        'nombre',
        'calidad',
        'marca',
        'formato',
        'stock',
        'precio_neto',
        'peso',
        'status',
    ];

    // Ejemplo de una relación (Si tienes otras tablas relacionadas, como categorías)
    // public function categoria() {
    //     return $this->belongsTo(Categoria::class);
    // }

    // Método para definir si el producto está activo basado en el stock
    public function isActive() {
        return $this->status === 'activo';
    }
}
