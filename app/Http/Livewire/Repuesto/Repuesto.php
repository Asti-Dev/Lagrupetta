<?php

namespace App\Http\Livewire\Repuesto;

use App\Models\Repuesto as ModelsRepuesto;
use Livewire\Component;
use Livewire\WithPagination;

class Repuesto extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;

    public $view = 'create';
    public $nombre;
    public $precio;
    public $activo = 0;
    public $nombreRepuesto = '';
    public $precioRepuesto;



    public $repuestoId;

    protected $rules = [
        'nombre' => 'required',
        'precio' => 'required',
        'activo' => 'required',

    ];

    public function updatingNombreRepuesto()
    {
        $this->resetPage();
    }
    public function updatingPrecioRepuesto()
    {
        $this->resetPage();
    }

    public function render()
    {
        
        $repuestos = ModelsRepuesto::buscarNombre($this->nombreRepuesto)
        ->buscarPrecio($this->precioRepuesto)
        ->orderBy('id', 'desc')->paginate(8);

        return view('livewire.repuesto.repuesto', compact('repuestos'))
        ->extends('layouts.app')
        ->section('content');
    }

    public function store()
    {
        $this->validate();

        $repuesto = ModelsRepuesto::create([
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'activo' => $this->activo,

        ]);


        $this->edit($repuesto->id);
    }

    public function edit($id)
    {
        $repuesto = ModelsRepuesto::where('id','=',$id)->first();

        $this->nombre = $repuesto->nombre;
        $this->precio = $repuesto->precio;
        $this->activo = $repuesto->activo;

        $this->repuestoId = $repuesto->id;

        $this->view = 'update';

    }
    public function update()
    {
        $this->validate();

        $repuesto = ModelsRepuesto::where('id','=',$this->repuestoId)->first();

        $repuesto->update([
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'activo' => $this->activo,

        ]);
    }

    public function default()
    {
        $this->nombre = '';
        $this->precio = '';
        $this->activo = 0;


        $this->view = 'create';

    }

    public function destroy($id)
    {
        ModelsRepuesto::where('id','=',$id)->delete();
    }
}
