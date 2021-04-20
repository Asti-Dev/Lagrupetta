<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function descargarDiagnosticoPedido (Pedido $pedido){

        $serial = $pedido->revision->diagnostico->serial;
        
        return Storage::disk('local')->download('/pdf/Diagnostico #'. $serial .'.pdf');
    }

    public function descargarDiagnostico (Diagnostico $diagnostico){

        $serial = $diagnostico->serial;
        
        return Storage::disk('local')->download('/pdf/Diagnostico #'. $serial .'.pdf');
    }
}
