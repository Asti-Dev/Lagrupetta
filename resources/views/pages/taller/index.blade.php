@extends('layouts.app')

@section('content')

@hasanyrole('jefe mecanicos|super-admin')

<livewire:almacen.ingreso.ingreso />

@endhasanyrole

<livewire:taller.taller />


@endsection