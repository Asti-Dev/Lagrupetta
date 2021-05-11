<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevisionPruebaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revision_prueba', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('revision_id')->unsigned();
            $table->foreign('revision_id')->references('id')->on('revisiones')->constrained();
            $table->foreignId('prueba_id')->constrained();
            $table->boolean('completado')->default(0);
            $table->boolean('corregir')->default(0);
            $table->string('comentario')->nullable();
            $table->string('respuesta')->nullable();
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
        Schema::dropIfExists('revision_prueba');
    }
}
