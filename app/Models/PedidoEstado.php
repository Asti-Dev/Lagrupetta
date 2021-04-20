<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PedidoEstado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pedido_estados';
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function pedidos(){
        return $this->hasMany(Pedido::class, 'pedido_estado_id', 'id');
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
