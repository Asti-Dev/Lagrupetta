<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Revision extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'revisiones';
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function pedido(){
        return $this->hasOne(Pedido::class, 'revision_id', 'id');
    }

    public function diagnostico(){
        return $this->belongsTo(Diagnostico::class);
    } 

    public function pruebas()
    {
        return $this->belongsToMany(Prueba::class, 'revision_prueba','revision_id','prueba_id')
        ->withPivot(
            'completado',
            'corregir',
            'comentario',
            'respuesta'
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
