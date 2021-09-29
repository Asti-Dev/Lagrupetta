<?php

namespace App\Http\Controllers;

use App\Models\Bicicleta;
use App\Models\Cliente;
use App\Models\Parte;
use App\Models\ParteModelo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nombre = $request->get('nombre');

        $clientes = Cliente::buscarNombre($nombre)->orderBy('id', 'desc')->paginate(5);

        return view('pages.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['tipoDoc'] = Cliente::TIPODOC;
        $data['distritos'] = Cliente::DISTRITOS;
        $data['llegadas'] = Cliente::LLEGADAS;

        return view('pages.clientes.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'distrito' => 'required',
            'email' =>  [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(Cliente::class),
            ]
        ]);

        $cliente = Cliente::create($request->all() +
        [
            'nombre_apellido' => $request['nombre'] . " " . $request['apellido']
        ]);

        if (!empty($request['marca']) && !empty($request['modelo'])) {
            $bicicleta = Bicicleta::create($request->all() +
                ['cliente_id' => $cliente->id] 
            );
    
            $parteModelos = ParteModelo::orderBy('id', 'asc')->get();
    
            foreach ($parteModelos as $parteModelo ) {
                Parte::create([
                        'parte_modelo_id' => $parteModelo->id,
                        'bicicleta_id' => $bicicleta->id,
                ]);
            }
        }

        return redirect()->route('clientes.index')
        ->with('success', 'Cliente creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        $data = [];
        $data['cliente'] = $cliente;
        $data['bicicletas'] = $cliente->bicicletas()->paginate(5);
        $data['pedidos'] = $cliente->pedidos()->paginate(5);


        return view('pages.clientes.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        $data['cliente'] = $cliente;
        $data['tipoDoc'] = Cliente::TIPODOC;
        $data['distritos'] = Cliente::DISTRITOS;
        $data['llegadas'] = Cliente::LLEGADAS;


        return view('pages.clientes.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'telefono' => 'required',
            'distrito' => 'required',
            'direccion' => 'required',
        ]);

        if ($request['email'] != $cliente->email) {
            $request->validate([
                'email' =>  [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(Cliente::class),
                ]
            ]);
            $cliente->update([
                'email' => $request['email'],
            ]);
        }

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
        ->with('success', 'Cliente actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')
        ->with('success', 'Cliente eliminado!');
    }
}
