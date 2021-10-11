<?php

namespace App\Http\Livewire\Import;

use App\Imports\RepuestoImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;


class Repuestos extends Component
{
    use WithFileUploads;

    public $file;

    public function updatedFile()
    {
        $this->validate([
            'file'=>'required|mimes:xlsx'
        ]);
    }

    public function importRepuesto()
    {
        $this->validate([
            'file'=>'required|mimes:xlsx'
        ]);
        $filePath = $this->file->store('imports');
        Excel::import(new RepuestoImport, $filePath);
        
        session()->flash('success', 'Repuestos cargados!');

        return redirect()->route('repuestos.index');

    }

    public function render()
    {
        return view('livewire.import.repuestos')
        ->extends('layouts.app')
        ->section('content');
    }
}
