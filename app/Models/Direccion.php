<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direcciones'; // Asegúrate de que este nombre coincida con el nombre de tu tabla

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }


}