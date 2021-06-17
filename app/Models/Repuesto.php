<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Repuesto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'repuestos';
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function pedidoDetalles()
    {
        return $this->belongsToMany(PedidoDetalle::class, 'pedido_detalle_repuesto','repuesto_id','pedido_detalle_id')
        ->withPivot(
            'cantidad_pendiente',
            'cantidad',
            'precio_total',
            'descuento',
            'precio_final',
            'checked',
        )->withTimestamps();

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
