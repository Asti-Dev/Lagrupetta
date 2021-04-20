<?php

namespace App\Scopes;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class MecanicoScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $empleado = Empleado::find(session()->get('empleado_id'));
        if($empleado){
            if($empleado->cargo == 'mecanico' || $empleado->cargo == 'jefe mecanicos'){
                $builder->where('mecanico', session()->get('empleado_id'));
            }
        }
    }
}