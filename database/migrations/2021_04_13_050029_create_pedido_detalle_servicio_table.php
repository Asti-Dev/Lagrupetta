<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoDetalleServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_detalle_servicio', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pedido_detalle_id')->unsigned();
            $table->foreign('pedido_detalle_id')->references('id')->on('pedido_detalles')->constrained();
            $table->foreignId('paquete_id')->nullable()->constrained();
            $table->foreignId('servicio_id')->nullable()->constrained();
            $table->integer('cantidad_pendiente')->nullable();
            $table->integer('cantidad')->nullable();
            $table->double('precio_total')->nullable();
            $table->double('descuento')->nullable();
            $table->double('precio_final')->nullable();
            $table->boolean('checked')->nullable()->default(0);
            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->bigInteger('updated_by')->nullable()->unsigned();
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('pedido_detalle_servicio');
    }
}
