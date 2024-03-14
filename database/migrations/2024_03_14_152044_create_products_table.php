<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_sku')->unique();
            $table->string('nombre');
            $table->string('calidad');
            $table->string('marca');
            $table->string('formato');
            $table->integer('stock');
            $table->decimal('precio_neto', 8, 2); // Ajusta la precisión según sea necesario
            $table->decimal('peso', 8, 2); // Ajusta la precisión según sea necesario
            $table->enum('status', ['activo', 'inactivo'])->default('activo'); // O usa un booleano si prefieres
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
