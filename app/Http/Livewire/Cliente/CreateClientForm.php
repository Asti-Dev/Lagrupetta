<?php

namespace App\Http\Livewire\Cliente;

use Livewire\Component;
use App\Models\Bicicleta;
use App\Models\Cliente;
use App\Models\Parte;
use App\Models\ParteModelo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CreateClientForm extends Component
{
    public $step = 0;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $direccion;
    public $tipo_doc;
    public $nro_doc;
    public $fecha_cumpleanos;
    public $marca;
    public $modelo;
    public $codigo;


    public function mount(){

    }

    public function nextStep(){
        $this->step++;
    }

    public function prevStep(){
        $this->step--;
    }

    public function save(){
        $this->validate(
            [
                'nombre' => 'required',
                'apellido' => 'required',
                'telefono' => 'required',
                'direccion' => 'required',
                'email' =>  [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                    ],
                'marca' => 'required',
                'modelo' => 'required',
                ]
        );

        $user = User::create([
            'name' => $this->nombre,
            'email' => $this->email,
            'password' => Hash::make('password'),
        ])->assignRole('cliente');

        $cliente = Cliente::create([
            'nombre' =>  $this->nombre,
            'apellido' =>  $this->apellido,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'email' => $this->email,
            'tipo_doc' => $this->tipo_doc,
            'nro_doc' => $this->nro_doc,
            'fecha_cumpleanos' => $this->fecha_cumpleanos,
            'user_id' => $user->id

        ]);

        $bicicleta = Bicicleta::create([
            'cliente_id' => $cliente->id,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'codigo' => $this->codigo ?? '',
            ] 
        );

        $parteModelos = ParteModelo::orderBy('id', 'asc')->get();

        foreach ($parteModelos as $parteModelo ) {
            Parte::create([
                    'parte_modelo_id' => $parteModelo->id,
                    'bicicleta_id' => $bicicleta->id,
            ]);
        }

        session()->flash('message', 'Cliente creado!');

    }

    public function render()
    {
        $data['tipoDoc'] = Cliente::TIPODOC;

        return view('livewire.cliente.create-client-form', $data)
        ->extends('layouts.app')
        ->section('content');
    }
}
