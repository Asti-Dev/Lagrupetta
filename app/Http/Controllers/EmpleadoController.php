<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $empleado = $request->get('empleado');
        $rol = $request->get('rol');

        $empleados = Empleado::buscarEmpleado($empleado)->filtrarRol($rol)->orderBy('id', 'desc')->paginate(5);

        return view('pages.empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['roles'] = Role::whereNotIn('name', ['super-admin', 'cliente'])->get();
        $data['tipoDoc'] = Empleado::TIPODOC;
        return view('pages.empleados.create', $data);
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
            'cargo' => 'required',
            'email' =>  [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ]
        ]);
        $user =  User::create([
            'name' => $request['nombre'],
            'email' => $request['email'],
            'password' => Hash::make('password'),
        ])->assignRole($request['cargo']);

        Empleado::create($request->all() +
        [
            'nombre_apellido' => $request['nombre'] . ' ' . $request['apellido'],
            'user_id' => $user->id
        ]);

        return redirect()->route('empleados.index')
        ->with('success', 'Empleado creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        return view('pages.empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        $data['empleado'] = $empleado;
        $data['tipoDoc'] = Empleado::TIPODOC;
        $data['roles'] = Role::whereNotIn('name', ['super-admin', 'cliente'])->get();

        return view('pages.empleados.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'telefono' => 'required',
            'cargo' => 'required',
        ]);

        if ($request['email'] != $empleado->user->email) {
            $request->validate([
                'email' =>  [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ]
            ]);
            $empleado->user->update([
                'email' => $request['email'],
            ]);
        }
        if ($request['cargo'] != $empleado->cargo) {
            $empleado->user->syncRoles($request['cargo']);
        }

        $empleado->update($request->all());
        return redirect()->route('empleados.index')
        ->with('success', 'Empleado actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        $user = User::find($empleado->user->id);
        $empleado->update([
            'user_id' => NULL,
        ]);
        $user->delete();
        $empleado->delete();

        return redirect()->route('empleados.index')
        ->with('success', 'Empleado eliminado!');
    }

    public function restorePassword(Empleado $empleado)
    {
        $user = User::find($empleado->user->id);

        $user->update([
            'password' => Hash::make('password'),
        ]);

        return redirect()->route('empleados.index')
        ->with('success', 'Contraseña reseteada!');
    }
}
