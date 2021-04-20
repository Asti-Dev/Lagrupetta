<?php

namespace App\Http\Livewire\ParteModelo;

use App\Models\ParteModelo as ModelsParteModelo;
use Livewire\Component;
use Livewire\WithPagination;

class ParteModelo extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;

    public $view = 'create';
    public $nombre;
    public $descripcion;
    public $tag;


    public $parteModeloId;

    protected $rules = [
        'nombre' => 'required',
    ];

    public function render()
    {
        $parteModelos = ModelsParteModelo::orderBy('id', 'desc')->paginate(8);

        return view('livewire.parte-modelo.parte-modelo', compact('parteModelos'))
        ->extends('layouts.app')
        ->section('content');
    }

    public function store()
    {
        $this->validate();

        $parteModelo = ModelsParteModelo::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tag' => $this->tag,

        ]);


        $this->edit($parteModelo->id);
    }

    public function edit($id)
    {
        $parteModelo = ModelsParteModelo::where('id','=',$id)->first();

        $this->parteModeloId = $parteModelo->id;
        $this->nombre = $parteModelo->nombre;
        $this->descripcion = $parteModelo->descripcion;
        $this->tag = $parteModelo->tag;


        $this->view = 'update';

    }
    public function update()
    {
        $this->validate();

        $parteModelo = ModelsParteModelo::where('id','=',$this->parteModeloId)->first();

        $parteModelo->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tag' => $this->tag,

        ]);

        session()->flash('success', 'Parte actualizada!');

    }

    public function default()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->tag = '';


        $this->view = 'create';

    }

    public function destroy($id)
    {
        ModelsParteModelo::where('id','=',$id)->delete();
    }
}
