<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderCompraAndTipoToPedidosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('orden_compra')->nullable();
            $table->string('tipo_pedido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('orden_compra');
            $table->dropColumn('tipo_pedido');
        });
    }
}
