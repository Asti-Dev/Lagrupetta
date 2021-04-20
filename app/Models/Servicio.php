<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Servicio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servicios';
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function pedidoDetalles()
    {
        return $this->belongsToMany(PedidoDetalle::class, 'pedido_detalle_servicio','servicio_id','pedido_detalle_id')
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

    public function paquetes()
    {
        return $this->belongsToMany(Paquetes::class, 'paquete_servicio', 'servicio_id', 'paquete_id')
        ->as('paquete-servicio');
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
}
