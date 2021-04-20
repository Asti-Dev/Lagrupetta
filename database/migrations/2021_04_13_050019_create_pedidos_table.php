<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pedido_estado_id')->nullable()->unsigned();
            $table->foreign('pedido_estado_id')->references('id')->on('pedido_estados')->constrained();
            $table->foreignId('cliente_id')->constrained();
            $table->foreignId('bicicleta_id')->constrained();
            $table->longText('observacion_cliente')->nullable();
            $table->dateTime('fecha_recojo_aprox')->nullable();
            $table->string('confirmacion')->nullable();
            $table->dateTime('fecha_hora_confirmacion')->nullable();
            $table->bigInteger('revision_id')->nullable()->unsigned();
            $table->foreign('revision_id')->references('id')->on('revisiones')->constrained();
            $table->bigInteger('pedido_detalle_id')->nullable()->unsigned();
            $table->foreign('pedido_detalle_id')->references('id')->on('pedido_detalles')->constrained();
            $table->string('codigo','6');
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
        Schema::dropIfExists('pedidos');
    }
}
