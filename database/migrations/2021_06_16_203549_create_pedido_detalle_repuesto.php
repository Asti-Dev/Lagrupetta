<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoDetalleRepuesto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_detalle_repuesto', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pedido_detalle_id')->unsigned();
            $table->foreign('pedido_detalle_id')->references('id')->on('pedido_detalles')->constrained();
            $table->foreignId('repuesto_id')->nullable()->constrained();
            $table->integer('cantidad_pendiente')->nullable();
            $table->integer('cantidad')->nullable();
            $table->double('precio_total')->nullable();
            $table->double('descuento')->nullable();
            $table->double('precio_final')->nullable();
            $table->boolean('checked')->nullable()->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('pedido_detalle_repuesto');
    }
}
