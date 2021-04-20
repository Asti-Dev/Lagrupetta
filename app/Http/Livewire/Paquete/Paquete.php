<?php

namespace App\Http\Livewire\Paquete;

use App\Models\Paquete as ModelsPaquete;
use App\Models\Servicio;
use Livewire\Component;
use Livewire\WithPagination;

class Paquete extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;

    public $view = 'create';
    public $nombresServicio = [];
    public $servicios =[];
    public $nombre;
    public $descripcion;
    public $precio;
    public $paqueteId;

    protected $rules = [
        'nombre' => 'required',
        'descripcion' => 'required',
        'precio' => 'required',
        'nombresServicio' => 'required',

    ];

    public function mount()
    {
        
    }


    public function render()
    {
        $data['paquetes'] = ModelsPaquete::orderBy('id', 'desc')->paginate(8);
        $data['serviciosSelect'] = Servicio::all();

        return view('livewire.paquete.paquete', $data )
        ->extends('layouts.app')
        ->section('content');
    }

    public function store()
    {
        $this->validate();

        $paquete = ModelsPaquete::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
        ]);

        $this->nombresServicio = $this->removeFalse($this->nombresServicio);

        if($this->nombresServicio != []){
            foreach ($this->nombresServicio as $key => $servicio) {

                    $paquete->servicios()->attach(
                        $key
                    );
                    $paquete->save();
                }
            
        }

        $this->edit($paquete->id);

    }

    public function edit($id)
    {
        $paquete = ModelsPaquete::where('id','=',$id)->first();

        $this->nombre = $paquete->nombre;
        $this->descripcion = $paquete->descripcion;
        $this->precio = $paquete->precio;
        $this->paqueteId = $paquete->id;
        $this->nombresServicio =  [];
            foreach ($paquete->servicios as $servicio) {
                $this->nombresServicio[$servicio->id] =
                    $servicio->id;
            }

        $this->view = 'update';

    }

    public function show($id)
    {
        $paquete = ModelsPaquete::where('id','=',$id)->first();

        $this->nombre = $paquete->nombre;
        $this->descripcion = $paquete->descripcion;
        $this->precio = $paquete->precio;

        $this->servicios = $paquete->servicios()->get();

        $this->view = 'show';

    }

    public function update(){
        $this->validate();

        $paquete = ModelsPaquete::where('id','=',$this->paqueteId)->first();

        $paquete->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
        ]);
        $paquete->save();

        $paquete->servicios()->detach();

        $this->nombresServicio = $this->removeFalse($this->nombresServicio);

        if($this->nombresServicio != []){
            foreach ($this->nombresServicio as $key => $servicio) {

                    $paquete->servicios()->attach(
                        $key
                    );
                    $paquete->save();
                }
            
        }


    }

    public function default()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->precio = '';

        $this->nombresServicio = [];

        $this->view = 'create';

    }

    public function destroy($id)
    {
        ModelsPaquete::where('id','=',$id)->delete();
    }

    public function removeFalse($array){
        $array = collect($array)->filter(function ($value, $key) {
            return $value != false;
        });

        return $array;
    }
}
