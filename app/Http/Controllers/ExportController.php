<?php

namespace App\Http\Controllers;

use App\Exports\RepuestosExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportRepuestos() 
    {
        return Excel::download(new RepuestosExport, 'repuestos-'. now() .'.xlsx');
    }
}
