<?php

namespace App\Http\Controllers;

use App\Models\Bicicleta;
use App\Models\Cliente;
use App\Models\Parte;
use App\Models\ParteModelo;
use Illuminate\Http\Request;

class BicicletaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cliente = Cliente::where('id', '=', $request['clienteId'])->first();

        return view('pages.bicicletas.create', compact('cliente'));
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
            'clienteId' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
        ]);

        $cliente = Cliente::where('id', '=', $request['clienteId'])->first();

        $bicicleta = Bicicleta::create($request->all() +
        ['cliente_id' => $request['clienteId']] 
        );

        $parteModelos = ParteModelo::orderBy('id', 'asc')->get();

        foreach ($parteModelos as $parteModelo ) {
            Parte::create([
                    'parte_modelo_id' => $parteModelo->id,
                    'bicicleta_id' => $bicicleta->id,
            ]);
        }

        return redirect()->route('clientes.show', compact('cliente'))
        ->with('success', 'Bicicleta creada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bicicleta  $bicicleta
     * @return \Illuminate\Http\Response
     */
    public function show(Bicicleta $bicicleta)
    {
        $data = [];
        $data['bicicleta'] = $bicicleta;

        return view('pages.bicicletas.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bicicleta  $bicicleta
     * @return \Illuminate\Http\Response
     */
    public function edit(Bicicleta $bicicleta)
    {
        $cliente = Cliente::where('id', '=', $bicicleta->cliente_id)->first();

        $data['cliente'] = $cliente;

        $data['bicicleta'] =$bicicleta;


        return view('pages.bicicletas.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bicicleta  $bicicleta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bicicleta $bicicleta)
    {
        $cliente = Cliente::where('id', '=', $bicicleta->cliente_id)->first();

        $request->validate([
            'marca' => 'required',
            'modelo' => 'required',
        ]);

        $bicicleta->update($request->all());

        return redirect()->route('clientes.show', compact('cliente'))
        ->with('success', 'Bicicleta actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bicicleta  $bicicleta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bicicleta $bicicleta)
    {
        $cliente = Cliente::where('id', '=', $bicicleta->cliente_id)->first();

        $bicicleta->delete();

        return redirect()->route('clientes.show', compact('cliente'))
            ->with('success', 'Bicicleta eliminada!');
    }
}
