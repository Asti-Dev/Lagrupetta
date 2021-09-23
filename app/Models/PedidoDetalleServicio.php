<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoDetalleServicio extends Model
{
    use HasFactory;

    protected $table = 'pedido_detalle_servicio';
    protected $guarded = [
        'id',
    ];

    public $timestamps = true;
}
