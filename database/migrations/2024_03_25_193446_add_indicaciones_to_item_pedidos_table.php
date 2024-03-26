<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('item_pedidos', function (Blueprint $table) {
            $table->text('indicaciones')->nullable();
        });
    }

    public function down()
    {
        Schema::table('item_pedidos', function (Blueprint $table) {
            $table->dropColumn('indicaciones');
        });
    }
};
