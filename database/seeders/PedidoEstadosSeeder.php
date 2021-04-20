<?php

namespace Database\Seeders;

use App\Models\PedidoEstado;
use Illuminate\Database\Seeder;

class PedidoEstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados =[
            ['nombre' => 'SOLICITADO'] ,
            ['nombre' => 'EN RUTA'] ,
            ['nombre' => 'RECOGIDO'] ,
            ['nombre' => 'EN TALLER'] ,
            ['nombre' => 'COTIZADO'] ,
            ['nombre' => 'EN PROCESO'] ,
            ['nombre' => 'EN ESPERA'] ,
            ['nombre' => 'REVISAR'] ,
            ['nombre' => 'CORREGIR'] ,
            ['nombre' => 'TERMINADO'] ,
            ['nombre' => 'ENTREGADO'] ,
            ['nombre' => 'PAGO PENDIENTE'] ,
            ['nombre' => 'COMPLETADO'] ,
            ['nombre' => 'ANULADO'] ,
        ];
        
        PedidoEstado::insert($estados);
    }
}
