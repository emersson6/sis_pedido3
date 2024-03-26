<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'cliente_id', 'direccion_id', 'costo_envio', 'comentarios', 'fecha_pedido', 'orden_compra', 'tipo_pedido', 'status'
    ];

    protected $dates = ['fecha_pedido'];
    protected $table = 'pedidos'; // Asegúrate de que solo se declare una vez

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function direccion()
    {
        return $this->belongsTo(Direccion::class);
    }

    public function ubicacion()
    {
        return $this->belongsTo(ubicacion::class);
    }

    public function items()
    {
        return $this->hasMany(ItemPedido::class);
    }
    public function fcomPedido()
    {
        return $this->hasOne(FcomPedido::class);
    }


}
