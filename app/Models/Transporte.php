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
                    return $query->whereBetween('created_at', [$fecha , $fecha2]);
                } else{
                    return $query->whereBetween('created_at', [$fecha , today()]);
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

    public function scopeFiltrarChofer($query, $chofer){
        if($chofer){
               return $query->where('chofer', $chofer);
        }
    }
    
}
