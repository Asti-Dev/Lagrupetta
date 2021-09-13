<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Transporte extends Model
{
    use HasFactory, SoftDeletes;

    const CUMPLIMIENTO = [
        'COMPLETADO',
        'FALLIDO'
    ];

    const RUTA = [
        'ENTREGA',
        'RECOJO'
    ];

    protected $table = 'transportes';
    protected $touches = ['pedido'];
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function choferTransporte(){
        return $this->belongsTo(Empleado::class, 'chofer', 'id' );
    } 

    public function pedido(){
        return $this->belongsTo(Pedido::class);
    } 

    protected static function boot()
    {
        
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            
            $model->updated_by = Auth::id();
        });
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }

    public function scopeChoferSession($query)
    {
        $empleado = Empleado::find(session()->get('empleado_id'));
        if($empleado){
            if($empleado->cargo == 'chofer'){
                return $query->where('chofer', session()->get('empleado_id'));
            }
        }
    }

    public function scopeFiltrarRuta($query, $ruta){
        if($ruta != ''){
            return $query->where('ruta', 'like', "%{$ruta}%");
        }
    }

    public function scopeFiltrarFecha($query, $fecha , $fecha2){
        if($fecha != ''){
                if($fecha2 != ''){
                    return $query->whereHas('pedido.pedidoDetalle', function($query2) use ($fecha , $fecha2){
                        $query2->whereBetween('fecha_entrega_aprox', [$fecha , $fecha2]);
                    })->orWhereHas('pedido', function( $query3 ) use ($fecha , $fecha2){
                        $query3->whereBetween('fecha_recojo_aprox', [$fecha , $fecha2]);
                    });;
                } else{
                    return $query->whereHas('pedido.pedidoDetalle', function($query2) use ($fecha){
                        $query2->where('fecha_entrega_aprox', $fecha);
                    })->orWhereHas('pedido', function($query2) use ($fecha){
                        $query2->where('fecha_recojo_aprox', $fecha);
                    });
                }
        }
    }

    public function scopeBuscarCliente($query, $cliente){
        if($cliente != ''){
            return $query->whereHas('pedido.cliente', function($query2) use ($cliente){
                $query2->where('nombre_apellido', 'like', "%{$cliente}%");
            });
        }
    }
    public function scopeBuscarPedido($query, $nroPedido){
        if($nroPedido != ''){
            return $query->whereHas('pedido', function($query2) use ($nroPedido){
                $query2->where('id', 'like', "%{$nroPedido}%");
            });
        }
    }
    
}
