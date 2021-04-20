<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Bicicleta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bicicletas';
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function parteModelos()
    {
        return $this->belongsToMany(ParteModelo::class, 'partes','bicicleta_id','parte_modelo_id')
        ->withPivot(
            'id',
            'porcentaje',
            'comentario',
            'detalle',
        );
    }

    public function partes()
    {
        return $this->hasMany(Parte::class);
    }

    public function diagnosticos()
    {
        return $this->hasMany(Diagnostico::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
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
            $model->partes()->delete();
            $model->pedidos()->delete();
            $model->diagnosticos()->delete();

        });
    }
}
