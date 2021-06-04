<?php

use App\Http\Controllers\BicicletaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConfirmationsController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Livewire\Cliente\CreateClientForm;
use App\Http\Livewire\Diagnostico\Diagnostico;
use App\Http\Livewire\Paquete\Paquete;
use App\Http\Livewire\ParteModelo\ParteModelo;
use App\Http\Livewire\Pedido\Pedido;
use App\Http\Livewire\Pedido\PedidoDetalle\Cotizar;
use App\Http\Livewire\Pedido\PedidoDetalle\PedidoDetalle;
use App\Http\Livewire\Pedido\Solicitud\Solicitud;
use App\Http\Livewire\Prueba\Prueba;
use App\Http\Livewire\Revision\Revision;
use App\Http\Livewire\Servicio\Servicio;
use App\Http\Livewire\Taller\Corregir;
use App\Http\Livewire\Taller\Taller;
use App\Http\Livewire\Test;
use App\Http\Livewire\Transporte\Transporte;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/aceptarSolicitud/{pedido}', [ConfirmationsController::class, 'aceptarSolicitud'])->name('pedido.aceptarSolicitud');

Route::get('/rechazarSolicitud/{pedido}', [ConfirmationsController::class, 'rechazarSolicitud'])->name('pedido.rechazarSolicitud');

Route::get('/aceptarCotizacion/{pedido}', [ConfirmationsController::class, 'aceptarCotizacion'])->name('pedido.aceptarCotizacion');

Route::get('/rechazarCotizacion/{pedido}', [ConfirmationsController::class, 'rechazarCotizacion'])->name('pedido.rechazarCotizacion');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', Test::class);

Route::get('/detallePDF', [ConfirmationsController::class, 'generatePDF'])->name('pdf')->middleware('auth');

Route::put('/diagnostico/{id}', [CotizacionController::class, 'diagnosticoSalida'])->name('diagnostico.create')->middleware('auth');

Route::get('/download/{pedido}', [DownloadController::class, 'descargarDiagnosticoPedido'])->name('download.diagnostico')->middleware('auth');

Route::get('/bicicleta/diagnostico/{diagnostico}', [DownloadController::class, 'descargarDiagnostico'])->name('download.diagnostico.bicicleta')->middleware('auth');

Route::view('/dashboard', 'home')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth', 'prefix' => 'administracion'], function() {

    Route::get('/quickClient', CreateClientForm::class)->name('quickClient');

    Route::resource('clientes', ClienteController::class);
    
    Route::resource('bicicletas', BicicletaController::class)->except(['index']);

    Route::resource('empleados', EmpleadoController::class);

    Route::get('/servicios', Servicio::class)->name('servicios.index');

    Route::get('/paquetes', Paquete::class)->name('paquetes.index');

    Route::get('/partes', ParteModelo::class)->name('partes-modelo.index');

    Route::get('/pruebas', Prueba::class)->name('pruebas.index');

    Route::get('/pedidos', Pedido::class)->name('pedidos.index');

    Route::get('/pedidos/{pedido}', Solicitud::class)->name('pedido.show');

});

Route::group(['middleware' => 'auth', 'prefix' => 'logistica'], function() {

    Route::get('/transportes', Transporte::class)->name('transportes.index');

    Route::get('/taller', Taller::class)->name('taller.index');

    Route::get('/salida/{pedidoDetalleId}', Diagnostico::class)->name('diagnostico.salida');

    Route::get('/corregir/{revisionId}', Corregir::class)->name('corregir');

    Route::get('/todoList/{pedidoDetalleId}', PedidoDetalle::class)->name('todoList');

    Route::get('/revisiones', Revision::class)->name('revisiones.index');

    Route::get('/cotizar/{pedidoDetalle}', Cotizar::class)->name('cotizar');

    Route::resource('cotizacion', CotizacionController::class)->only(['update']);
});