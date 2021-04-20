<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Diagnostico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'diagnosticos';
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function mecanico(){
        return $this->belongsTo(Empleado::class, 'mecanico', 'id' );
    } 

    public function bicicleta(){
        return $this->belongsTo(Bicicleta::class);
    }

    public function pedidoDetalle(){
        return $this->hasOne(PedidoDetalle::class);
    }

    public function revision(){
        return $this->hasOne(Revision::class);
    }

    public function logs(){
        return $this->hasMany(DiagnosticoLog::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
        });
        static::created(function ($model) {
            $log = DiagnosticoLog::create();
            $log->update([
                'diagnostico_id' => $model->id,
                'data' => $model->data,
            ]);
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
        
        static::updated(function ($model) {
            $model->logs->create([
                'data' => $model->data,
            ]);     
        });
    }
}
