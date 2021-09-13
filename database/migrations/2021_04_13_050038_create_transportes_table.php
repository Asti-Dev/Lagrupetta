<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chofer')->nullable()->unsigned();
            $table->foreign('chofer')->references('id')->on('empleados')->constrained();
            $table->foreignId('pedido_id')->constrained();
            $table->string('completado')->nullable();
            $table->string('ruta')->nullable();
            $table->boolean('check')->default(0);
            $table->longText('observacion_chofer')->nullable();
            $table->dateTime('fecha_hora_completado')->nullable();
            $table->dateTime('fecha_hora_local')->nullable();
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
        Schema::dropIfExists('transportes');
    }
}
