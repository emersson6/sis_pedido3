<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'rut',
        'nombre',
        'direccion_matriz',
        'ubicacion_id',
        'fono',
        'nombre_contacto',
        'fono_contacto',
        'tipo_cliente',
        'canal_venta',
    ];


    public function direcciones()
    {
        return $this->hasMany(Direccion::class);
    }
}
