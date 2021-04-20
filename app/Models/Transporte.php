<?php

namespace App\Models;

use App\Scopes\ChoferScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Transporte extends Model
{
    use HasFactory, SoftDeletes;

    const CUMPLIMIENTO = [
        'COMPLETADO',
        'FALLIDO'
    ];

    const RUTA = [
        'ENTREGA',
        'RECOJO'
    ];

    protected $table = 'transportes';
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function choferTransporte(){
        return $this->belongsTo(Empleado::class, 'chofer', 'id' );
    } 

    public function pedido(){
        return $this->belongsTo(Pedido::class);
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

    protected static function booted()
    {
        static::addGlobalScope(new ChoferScope);
    }
}
