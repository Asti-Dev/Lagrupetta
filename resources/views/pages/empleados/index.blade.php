@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-2">
            <div class="my-3">
                <h2>Empleados </h2>
            </div>
            <div class="d-flex align-items-strech my-1">
                 <a class="btn btn-success" href="{{ route('empleados.create') }}" title="Crear empleado">
                    Nuevo
                </a>
                <a class="btn btn-success" href="{{ route('empleados.index') }}">
                    Limpiar
                </a>
                <form class="form-inline mx-2" action="{{route('empleados.index')}}" method="GET">
                    <div class="form-group">
                        <select class="form-control" id="estados" name="rol">
                          <option value=''>Todos los roles</option>
                          <option value='administrador'>Administrador  </option>
                          <option value='chofer'>Chofer </option>
                          <option value='mecanico'>Mecanico </option>
                          <option value='jefe mecanicos'> Jefe de mecanicos  </option>
                        </select>
                      </div>
                    <div class="form-group row ml-3">
                      <label class="col-sm-2 col-form-label" for="empleado">Empleado</label>
                      <div class="col-sm-10">
                          <input type="text" name="empleado" class="form-control" id="empleado">
                      </div>
                    </div>
                    <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                  </form>
            </div>
        </div>
    </div>
    

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered table-responsive">
        <thead class="thead-dark">
            <tr class="">
                <th scope="col">Acciones</th>
                <th scope="col">No </th>
                <th scope="col">Nombre
                </th>
                <th scope="col">Telefono
                </th>
                <th scope="col">Cargo
                </th>
                <th scope="col">Tipo de Documento
                </th>
                <th scope="col">Nro Documento
                </th>
                <th scope="col">Email
                </th>
                <th scope="col">Fecha de Cumpleaños
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $empleado)
                <tr>
                    <td class="d-flex flex-column justify-content-between align-items-center" style="height: 100px" scope="row">
                        <div class="d-flex">
                            <a class="mx-1" href="{{ route('empleados.show', $empleado->id) }}" title="show">
                                <i class="fas fa-eye text-success  fa-lg"></i>
                            </a>
                            <a class="mx-1" href="{{ route('empleados.edit', $empleado->id) }}">
                                <i class="fas fa-edit  fa-lg"></i>
                            </a>
                            <form class="mx-1" style="width: min-content"
                                action="{{ route('empleados.destroy', $empleado->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" onclick="return confirm('¿Estas seguro de borrar al empleado?')"
                                    title="delete" style="padding:0px; border: none; background-color:transparent;">
                                    <i class="fas fa-trash fa-lg text-danger"></i>
                                </button>
                            </form>
                        </div>

                            <div>
                                <form class="mx-1" style="width: min-content"
                                    action="{{ route('empleado.reset', $empleado->id) }}" method="GET">
                                    <button type="submit" class="btn btn-warning" onclick="return confirm('¿Estas seguro que deseas resetear la contraseña?')"
                                        title="resetear contraseña" style="font-size:0.8rem; border: none;">
                                        <i class="fas fa-key"></i>
                                    </button>
                                </form>
                            </div>
                    </td>
                    <td>{{ $empleado->id }}</td>
                    <td>{{ $empleado->nombre_apellido }}</td>
                    <td>{{ $empleado->telefono }}</td>
                    <td>{{ $empleado->cargo }}</td>
                    <td>{{ $empleado->tipo_doc }}</td>
                    <td>{{ $empleado->nro_doc }}</td>
                    <td>{{ $empleado->user->email }}</td>
                    <td>{{ $empleado->fecha_cumpleanos }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

{{ $empleados->links('pagination::bootstrap-4') }} 

@endsection
