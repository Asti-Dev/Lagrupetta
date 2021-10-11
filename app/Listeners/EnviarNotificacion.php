<?php

namespace App\Listeners;

use App\Events\ProcesarNotificacion;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Models\Role;

class EnviarNotificacion
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProcesarNotificacion  $event
     * @return void
     */
    public function handle(ProcesarNotificacion $event)
    {
        $roles = Role::whereNotIn('name', ['cliente'])->pluck('name')->toArray();
        $users = User::with('empleado')->role($roles)->get();
        $admins = [];
        $choferes = [];
        $mecanicos = [];
        $jefe_mecanicos = [];

        foreach ($users as $user) {
             if ($user->hasRole(['super-admin','administrador'])) {
                array_push($admins,$user);
             } elseif ($user->hasRole(['chofer'])) {
                array_push($choferes,$user);
             } elseif ($user->hasRole(['mecanico'])) {
                array_push($mecanicos,$user);
             } elseif ($user->hasRole(['jefe mecanicos'])) {
                array_push($jefe_mecanicos,$user);
             }
         };
        
        $choferArray = array('EN RUTA RECOJO','EN RUTA ENTREGA','TERMINADO');
        $mecanicoArray = array('EN TALLER','COTIZADO','CORREGIR','TERMINADO');
        $jefeMecanicosAsignarArray = array('DEPOSITADO');
        $jefeMecanicosTallerArray = array('COTIZADO');
        $jefeMecanicosCalidadArray = array('EN CALIDAD');


        
        foreach ($admins as $admin) {
            $event->pedidoLog->usuarios()->attach($admin->id);
        }
        if (in_array($event->pedidoLog->pedidoEstado->nombre,$choferArray) ) {
            if ($event->pedidoLog->sub_estado = '') {
                foreach ($choferes as $user) {
                    $choferAsignado = $event->pedidoLog->pedido->transporteEntrega->chofer ?? $event->pedidoLog->pedido->transporteRecojo->chofer;
                    if ($user->empleado->id === $choferAsignado) {
                        $event->pedidoLog->usuarios()->attach($user->id);
                    }
                }
            }
        }
        if (in_array($event->pedidoLog->pedidoEstado->nombre,$mecanicoArray) ) {
            foreach ($mecanicos as $user) {
                $mecanicoAsignado = $event->pedidoLog->pedido->pedidoDetalle->mecanico ?? 0;
                if ($user->empleado->id === $mecanicoAsignado) {
                    $event->pedidoLog->usuarios()->attach($user->id);
                }
            }
        }

        if (in_array($event->pedidoLog->pedidoEstado->nombre,$jefeMecanicosAsignarArray) ) {
            foreach ($jefe_mecanicos as $user) {
                    $event->pedidoLog->usuarios()->attach($user->id);
            }
        }

        if (in_array($event->pedidoLog->pedidoEstado->nombre,$jefeMecanicosTallerArray) ) {
            foreach ($jefe_mecanicos as $user) {
                $mecanicoAsignado = $event->pedidoLog->pedido->pedidoDetalle->mecanico ?? 0;
                if ($user->empleado->id === $mecanicoAsignado) {
                    $event->pedidoLog->usuarios()->attach($user->id);
                }
            }
        }

        if (in_array($event->pedidoLog->pedidoEstado->nombre,$jefeMecanicosCalidadArray) ) {
            foreach ($jefe_mecanicos as $user) {
                $mecanicoAsignado = $event->pedidoLog->pedido->revision->mecanico ?? 0;
                if ($user->empleado->id === $mecanicoAsignado) {
                    $event->pedidoLog->usuarios()->attach($user->id);
                }
            }
        }
    }
}
