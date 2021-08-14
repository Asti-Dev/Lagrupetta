<?php

namespace App\Models;

use App\Scopes\MecanicoScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PedidoDetalle extends Model
{
    use HasFactory, SoftDeletes;

    const ESTADOS = [
        'ACEPTADO',
        'EN ESPERA',
        'RECHAZADO'
    ];

    protected $table = 'pedido_detalles';
    protected $touches = ['pedido'];
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function pedido(){
        return $this->hasOne(Pedido::class, 'pedido_detalle_id', 'id');
    }

    public function mecanicoUno(){
        return $this->belongsTo(Empleado::class, 'mecanico', 'id' );
    } 

    public function diagnostico(){
        return $this->belongsTo(Diagnostico::class);
    } 

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'pedido_detalle_servicio','pedido_detalle_id','servicio_id')
        ->withPivot(
            'paquete_id',
            'cantidad_pendiente',
            'cantidad',
            'precio_total',
            'descuento',
            'precio_final',
            'checked',
        );
    }

    public function repuestos()
    {
        return $this->belongsToMany(Repuesto::class, 'pedido_detalle_repuesto','pedido_detalle_id','repuesto_id')
        ->withPivot(
            'cantidad_pendiente',
            'cantidad',
            'precio_total',
            'descuento',
            'precio_final',
            'checked',
        )->withTimestamps();
    }

    public function paquetes()
    {
        return $this->belongsToMany(Paquete::class, 'pedido_detalle_servicio','pedido_detalle_id','paquete_id')
        ->withPivot(
            'servicio_id',
            'cantidad_pendiente',
            'cantidad',
            'precio_total',
            'descuento',
            'precio_final',
            'checked',
        );
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
        static::deleting(function($model) {
            $model->diagnostico()->delete();
        });
    }

    public function scopeMecanicoSession($query){
        $empleado = Empleado::find(session()->get('empleado_id'));
        if($empleado){
            if($empleado->cargo == 'mecanico' || $empleado->cargo == 'jefe mecanicos'){
               return $query->where('mecanico', session()->get('empleado_id'));
            }
        }
    }
    public function scopeFiltrarEstadoPedido($query, $estado){
        if($estado != ''){
            return $query->whereHas('pedido.pedidoEstado', function($query2) use ($estado){
                $query2->where('nombre', 'like', "%{$estado}%");
            });
        }
    }

    public function scopeBuscarCliente($query, $cliente){
        if($cliente != ''){
            return $query->whereHas('pedido.cliente', function($query2) use ($cliente){
                $query2->where('nombre', 'like', "%{$cliente}%")
                ->orWhere('apellido', 'like', "%{$cliente}%");
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
