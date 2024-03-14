<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            $table->string('tipo'); // Ejemplo: casa, trabajo, sucursal, etc.
            $table->string('direccion');
            // Quita las claves foráneas ya que no hay una tabla 'comunas' o 'regiones' separada
            $table->unsignedBigInteger('ubicacion_id');
            $table->timestamps();

            // Establece la clave foránea referenciando la tabla 'ubicaciones'
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccion');
    }
};
