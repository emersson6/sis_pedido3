<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direcciones'; // Asegúrate de que este nombre coincida con el nombre de tu tabla
    protected $fillable = [
        'cliente_id',
        'tipo',
        'direccion',
        'ubicacion_id',
    ];



    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'direccion_id');
    }


}
