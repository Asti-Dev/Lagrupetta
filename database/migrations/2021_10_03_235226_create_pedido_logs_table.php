<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pedido_id')->nullable()->unsigned();
            $table->foreign('pedido_id')->references('id')->on('pedidos');
            $table->bigInteger('pedido_estado_id')->nullable()->unsigned();
            $table->foreign('pedido_estado_id')->references('id')->on('pedido_estados');
            $table->string('sub_estado')->nullable();
            $table->boolean('eliminado')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedido_logs');
    }
}
