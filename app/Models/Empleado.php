<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Empleado extends Model
{
    use HasFactory, SoftDeletes;

    const TIPODOC = [
        'DNI',
        'PASAPORTE',
        'CE'
    ];
    
    protected $table = 'empleados';
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function pedidodDetalles(){
        return $this->hasMany(PedidoDetalle::class, 'mecanico' , 'id');
    }

    public function transportes(){
        return $this->hasMany(Transporte::class, 'chofer' , 'id');
    }

    public function revisiones(){
        return $this->hasMany(Revision::class, 'mecanico' , 'id');
    }

    public function diagnosticos()
    {
        return $this->hasMany(Diagnostico::class, 'mecanico', 'id' );   
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

    public function scopeBuscarEmpleado($query, $empleado){
        if($empleado != ''){
            return $query->where('nombre_apellido', 'like', "%{$empleado}%");
        }
    }
    public function scopeFiltrarRol($query, $rol){
        if($rol != ''){
            return $query->whereHas('user', function($query2) use ($rol){
                $query2->role($rol);
            });
        }
    }
}
