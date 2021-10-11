<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoLog extends Model
{
    use HasFactory;

    protected $table = 'pedido_logs';
    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y h:i A',
    ];

    public $timestamps = true; 

    public function pedidoEstado(){
        return $this->belongsTo(PedidoEstado::class, 'pedido_estado_id', 'id');
    }

    public function pedido(){
        return $this->belongsTo(Pedido::class, 'pedido_id', 'id')->withTrashed();
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'pedido_logs_usuario', 'pedido_log_id', 'user_id')
        ->withPivot('visto')
        ->withTimestamps();
    }

    public function scopeFiltrarEstadoPedido($query, $estado){
        if($estado != ''){
            if ($estado == 'ANULADO') {
                return $query->onlyTrashed();
            } else {
                return $query->whereHas('pedidoEstado', function($query2) use ($estado){
                    $query2->where('nombre', 'like', "%{$estado}%");
                });
            }
            
        }
    }

    public function scopeFiltrarFecha($query, $fecha , $fecha2, $campo){
        if($fecha != ''){
            $fecha = new Carbon($fecha);
                if($fecha2 != ''){
                    $fecha2 = new Carbon($fecha2);
                    return $query->whereBetween($campo, [$fecha->format('Y-m-d')." 00:00:00" , $fecha2->format('Y-m-d')." 23:59:59"]);
                } else{
                    return $query->whereBetween($campo, [$fecha->format('Y-m-d')." 00:00:00" , now()]);
                }
        }
    }

    public function scopeBuscarPedido($query, $nroPedido){
        if($nroPedido != ''){
            return $query->where('pedido_id', 'like', "%{$nroPedido}%");
        }
    }
    
}
