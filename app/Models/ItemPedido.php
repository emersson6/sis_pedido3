<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_neto',
        'subtotal',
        'indicaciones',
    ];

    protected $table = 'item_pedidos'; // Asegúrate de que coincida con el nombre de tu tabla


    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
