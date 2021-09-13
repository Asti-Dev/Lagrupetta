<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Pedido extends Model
{
    use HasFactory, SoftDeletes;

    const ESTADOS = [
        'ACEPTADO',
        'EN ESPERA',
        'RECHAZADO'
    ];

    protected $table = 'pedidos';
    protected $guarded = [
        'id',
    ];
    protected $casts = [
        'fecha_recojo_aprox' => 'date',
    ];

    public $timestamps = true; 

    public function cliente(){
        return $this->belongsTo(Cliente::class)->withTrashed();
    }

    public function bicicleta(){
        return $this->belongsTo(Bicicleta::class)->withTrashed();
    }

    public function pedidoEstado(){
        return $this->belongsTo(PedidoEstado::class, 'pedido_estado_id', 'id');
    }

    public function pedidoDetalle(){
        return $this->belongsTo(PedidoDetalle::class, 'pedido_detalle_id', 'id')->withTrashed();
    }

    public function revision(){
        return $this->belongsTo(Revision::class, 'revision_id', 'id')->withTrashed();
    }

    public function transportes()
    {
        return $this->hasMany(Transporte::class);
    }

    public function transporteRecojo()
    {
        return $this->hasOne(Transporte::class)->where('ruta', 'RECOJO')->withTrashed();
    }

    public function transporteEntrega()
    {
        return $this->hasOne(Transporte::class)->where('ruta', 'ENTREGA')->withTrashed();
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
            $model->codigo = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        });
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
        
        static::restoring(function($model) {
            $model->transportes()->restore();
            $model->revision()->restore();
            $model->pedidoDetalle()->restore();
        });

        static::deleting(function($model) {
            $model->transportes()->delete();
            $model->revision()->delete();
            $model->pedidoDetalle()->delete();
        });
        
    }

    public function scopeFiltrarEstadoPedido($query, $estado){
        if($estado != ''){
            if ($estado == 'ANULADO') {
                return $query->onlyTrashed();
            } else {
                return $query->whereHas('pedidoEstado', function($query2) use ($estado){
                    $query2->where('nombre', 'like', "%{$estado}%");
                });
            }
            
        }
    }
    public function scopeBuscarCliente($query, $cliente){
        if($cliente != ''){
            return $query->whereHas('cliente', function($query2) use ($cliente){
                $query2->where('nombre_apellido', 'like', "%{$cliente}%");
            });
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

}
