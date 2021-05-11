<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnostico_id')->nullable()->constrained();
            $table->longText('explicacion')->nullable();
            $table->dateTime('fecha_entrega_aprox')->nullable();
            $table->double('precio_total')->nullable();
            $table->double('descuento')->nullable();
            $table->double('precio_final')->nullable();
            $table->string('confirmacion')->nullable();
            $table->dateTime('fecha_confirmacion')->nullable();
            $table->bigInteger('mecanico')->nullable()->unsigned();
            $table->foreign('mecanico')->references('id')->on('empleados')->constrained();
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
        Schema::dropIfExists('pedido_detalles');
    }
}
