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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('rut')->unique();
            $table->string('nombre');
            $table->string('direccion_matriz');
            // Quita las claves foráneas ya que no hay una tabla 'comunas' o 'regiones' separada
            $table->unsignedBigInteger('ubicacion_id');
            $table->string('fono');
            $table->string('nombre_contacto');
            $table->string('fono_contacto');
            $table->enum('tipo_cliente', ['externo', 'interno']);
            $table->string('canal_venta');
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
        Schema::dropIfExists('clientes');
    }
};
