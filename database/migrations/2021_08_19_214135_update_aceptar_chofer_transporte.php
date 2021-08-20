<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAceptarChoferTransporte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transportes', function (Blueprint $table) {
            $table->dateTime('fecha_hora_aceptar_chofer')->nullable()->after('pedido_id');
            $table->string('aceptar_chofer')->nullable()->after('pedido_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transportes', function (Blueprint $table) {
            $table->dropColumn('aceptar_chofer');
            $table->dropColumn('fecha_hora_aceptar_chofer');

        });
    }
}
