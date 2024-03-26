<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FcomPedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'unidad_negocio',
        'centro_costo',
        'solicitado_por',
        'fecha_solicitud',
        'fecha_despacho_requerida',
        'objetivo_muestra',
        'zona_venta',
        // Agregar otros campos necesarios
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
