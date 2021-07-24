<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    const TIPODOC = [
        'DNI',
        'PASAPORTE',
        'CE'
    ];

    protected $table = 'clientes';
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function bicicletas(){
        return $this->hasMany(Bicicleta::class);
    }

    public function pedidos(){
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
            $model->bicicletas()->delete();
            $model->pedidos()->delete();
        });
    }

    public function scopeBuscarNombre($query, $nombre){
        if($nombre != ''){
            return $query->where('nombre_apellido', 'like', "%{$nombre}%");
        }
    }
}
