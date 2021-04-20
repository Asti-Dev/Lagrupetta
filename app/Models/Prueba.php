<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Prueba extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pruebas';
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function revisiones()
    {
        return $this->belongsToMany(Revision::class, 'revision_prueba','prueba_id','revision_id')
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
    }
}
