<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    const LLEGADAS = [
        'Redes',
        'Van',
        'Competencia',
        'Feria',
        'Referido',
        'Otros'
    ];

    const DISTRITOS = [
        'Ancón',
        'Ate',
        'Barranco',
        'Bellavista',
        'Brena',
        'Carmen de la Legua',
        'Chorrilos',
        'Comas',
        'El Agustino',
        'Independencia',
        'Jesus Maria',
        'La Victoria',
        'La Perla',
        'La Punta',
        'Lince',
        'Lima Cercado',
        'Los Olivos',
        'Magdalena',
        'Miraflores',
        'Pueblo Libre',
        'Rimac',
        'San Borja',
        'San Juan de Miraflores',
        'San Juan de Lurigancho',
        'San Isidro',
        'San Luis',
        'San Martin de Porres',
        'Santa Anita' , 
        'San Miguel' , 
        'Surco' , 
        'Surquillo' ,
    ];

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
        return $this->hasMany(Pedido::class)->orderBy('id','desc');
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
