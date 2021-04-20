<?php

namespace App\Http\Livewire\Servicio;

use App\Models\Servicio as ModelsServicio;
use Livewire\Component;
use Livewire\WithPagination;

class Servicio extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;

    public $view = 'create';
    public $nombre;
    public $precio;
    public $activo;


    public $servicioId;

    protected $rules = [
        'nombre' => 'required',
        'precio' => 'required',
        'activo' => 'required',

    ];

    public function render()
    {
        $servicios = ModelsServicio::orderBy('id', 'desc')->paginate(8);

        return view('livewire.servicio.servicio', compact('servicios'))
        ->extends('layouts.app')
        ->section('content');
    }

    public function store()
    {
        $this->validate();

        $servicio = ModelsServicio::create([
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'activo' => $this->activo,

        ]);


        $this->edit($servicio->id);
    }

    public function edit($id)
    {
        $servicio = ModelsServicio::where('id','=',$id)->first();

        $this->nombre = $servicio->nombre;
        $this->precio = $servicio->precio;
        $this->activo = $servicio->activo;

        $this->servicioId = $servicio->id;

        $this->view = 'update';

    }
    public function update()
    {
        $this->validate();

        $servicio = ModelsServicio::where('id','=',$this->servicioId)->first();

        $servicio->update([
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'activo' => $this->activo,

        ]);
    }

    public function default()
    {
        $this->nombre = '';
        $this->precio = '';


        $this->view = 'create';

    }

    public function destroy($id)
    {
        ModelsServicio::where('id','=',$id)->delete();
    }
}
