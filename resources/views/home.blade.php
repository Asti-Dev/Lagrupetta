@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        Tu rol es {{Auth::user()->getRoleNames() ?? ''}}
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            @hasanyrole('super-admin|administrador|chofer|jefe mecanicos')
            <livewire:widget.mecanicos />
            @endhasanyrole
        </div>
        <div class="col-md-6">
            <livewire:widget.charts.chart1 />
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <livewire:widget.charts.chart3 />
        </div>
        <div class="col-md-6">
            <livewire:widget.charts.chart2 />
        </div>
    </div>
</div>
@endsection
@section('javascript')

@endsection
