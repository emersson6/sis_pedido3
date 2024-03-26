<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fcom_pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained()->onDelete('cascade');
            $table->string('unidad_negocio')->nullable();
            $table->string('centro_costo')->nullable();
            $table->string('solicitado_por');
            $table->date('fecha_solicitud'); // Removido el valor por defecto
            $table->date('fecha_despacho_requerida');
            $table->text('objetivo_muestra')->nullable();
            $table->string('zona_venta');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fcom_pedidos');
    }
};
