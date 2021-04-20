<?php

namespace App\Http\Livewire\Prueba;

use App\Models\Prueba as ModelsPrueba;
use Livewire\Component;
use Livewire\WithPagination;

class Prueba extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;

    public $view = 'create';
    public $nombre;
    public $descripcion;

    public $pruebaId;

    protected $rules = [
        'nombre' => 'required',
    ];

    public function render()
    {
        $pruebas = ModelsPrueba::orderBy('id', 'desc')->paginate(8);

        return view('livewire.prueba.prueba', compact('pruebas'))
        ->extends('layouts.app')
        ->section('content');
    }

    public function store()
    {
        $this->validate();

        $prueba = ModelsPrueba::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
        ]);


        $this->edit($prueba->id);
    }

    public function edit($id)
    {
        $prueba = ModelsPrueba::where('id','=',$id)->first();

        $this->nombre = $prueba->nombre;
        $this->descripcion = $prueba->descripcion;
        $this->pruebaId = $prueba->id;

        $this->view = 'update';

    }
    public function update()
    {
        $this->validate();

        $prueba = ModelsPrueba::where('id','=',$this->pruebaId)->first();

        $prueba->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
        ]);
    }

    public function default()
    {
        $this->nombre = '';
        $this->descripcion = '';

        $this->view = 'create';

    }

    public function destroy($id)
    {
        ModelsPrueba::where('id','=',$id)->delete();
    }
}
