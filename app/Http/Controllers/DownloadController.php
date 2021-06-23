<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function descargarDiagnosticoPedido (Pedido $pedido){

        if(is_null($pedido->revision)){
            $serial = $pedido->pedidoDetalle->diagnostico->serial;
            $nombre = 'Diagnostico #';
        } else {
            $serial = $pedido->revision->diagnostico->serial;
            $nombre = 'Informe Final #';
        }
        
        return Storage::disk('local')->download('/pdf/'. $nombre . $serial .'.pdf');
    }

    public function descargarDiagnostico (Diagnostico $diagnostico){

        $serial = $diagnostico->serial;
        $nombre = 'Diagnostico #';

        if ($diagnostico->salida == 1) {
            $nombre = 'Informe Final #';
        }
        
        
        return Storage::disk('local')->download('/pdf/'. $nombre . $serial .'.pdf');
    }
}
