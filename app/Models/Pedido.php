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
        return $this->belongsTo(PedidoDetalle::class, 'pedido_detalle_id', 'id');
    }

    public function revision(){
        return $this->belongsTo(Revision::class, 'revision_id', 'id');
    }

    public function transportes()
    {
        return $this->hasMany(Transporte::class);
    }

    public function transporteRecojo()
    {
        return $this->hasMany(Transporte::class)->where('ruta', 'RECOJO')->first();
    }

    public function transporteEntrega()
    {
        return $this->hasMany(Transporte::class)->where('ruta', 'ENTREGA')->first();
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
        
        static::deleting(function($model) {
            $model->transportes()->delete();
            $model->revision()->delete();
            $model->pedidoDetalle()->delete();
        });
        
    }
}
