<?php

namespace App\Http\Controllers;

use App\Imports\ClienteImport;
use App\Imports\RepuestoImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function importRepuesto(){
        Excel::import(new RepuestoImport, request()->file('file'));
        
        return redirect('/home')->with('success', 'All good!');
    }

    public function importCliente(){
        Excel::import(new ClienteImport, request()->file('file'));
        
        return redirect('/home')->with('success', 'All good!');
    }
}
