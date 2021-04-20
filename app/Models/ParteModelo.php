<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ParteModelo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'parte_modelos';
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;

    public function partes()
    {
        return $this->hasMany(Parte::class, 'parte_modelo_id','id');
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
