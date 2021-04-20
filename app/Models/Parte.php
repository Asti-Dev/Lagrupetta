<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Parte extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'partes';
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function parteModelo(){
        return $this->belongsTo(ParteModelo::class,'parte_modelo_id','id');
    }

    public function bicicleta(){
        return $this->belongsTo(Bicicleta::class);
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
