<?php

use App\Http\Controllers\BicicletaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConfirmationsController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\WhatsappController;
use App\Http\Livewire\Cliente\CreateClientForm;
use App\Http\Livewire\Diagnostico\Diagnostico;
use App\Http\Livewire\Paquete\Paquete;
use App\Http\Livewire\ParteModelo\ParteModelo;
use App\Http\Livewire\Pedido\Pedido;
use App\Http\Livewire\Pedido\PedidoDetalle\Cotizacion\CotizacionEdit;
use App\Http\Livewire\Pedido\PedidoDetalle\Cotizar;
use App\Http\Livewire\Pedido\PedidoDetalle\PedidoDetalle;
use App\Http\Livewire\Pedido\Solicitud\Solicitud;
use App\Http\Livewire\Prueba\Prueba;
use App\Http\Livewire\Repuesto\Repuesto;
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

Route::get('/test', Test::class)->middleware(['role:super-admin']);;

Route::get('/detallePDF', [ConfirmationsController::class, 'generatePDF'])->name('pdf')->middleware('auth');

Route::put('/diagnostico/{id}', [CotizacionController::class, 'diagnosticoSalida'])->name('diagnostico.create')->middleware('auth');

Route::get('/download/{pedido}', [DownloadController::class, 'descargarDiagnosticoPedido'])->name('download.diagnostico')->middleware('auth');

Route::view('/dashboard', 'home')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth', 'prefix' => 'administracion'], function() {

    Route::get('/quickClient', CreateClientForm::class)->name('quickClient')->middleware(['role:super-admin|administrador']);

    Route::resource('clientes', ClienteController::class)->middleware(['role:super-admin|administrador']);
    
    Route::resource('bicicletas', BicicletaController::class)->except(['index'])->middleware(['role:super-admin|administrador']);

    Route::get('/bicicleta/diagnostico/{diagnostico}', [DownloadController::class, 'descargarDiagnostico'])->name('download.diagnostico.bicicleta');

    Route::resource('empleados', EmpleadoController::class)->middleware(['role:super-admin|administrador']);

    Route::get('/whatsapp/{pedido}', [WhatsappController::class, 'sendMessage'])->name('whatsapp.sendMessage')->middleware(['role:super-admin|administrador']);

    Route::get('/servicios', Servicio::class)->name('servicios.index')->middleware(['role:super-admin|administrador']);

    Route::get('/repuestos', Repuesto::class)->name('repuestos.index')->middleware(['role:super-admin|administrador']);

    Route::get('/paquetes', Paquete::class)->name('paquetes.index')->middleware(['role:super-admin|administrador']);

    Route::get('/partes', ParteModelo::class)->name('partes-modelo.index')->middleware(['role:super-admin|administrador']);

    Route::get('/pruebas', Prueba::class)->name('pruebas.index')->middleware(['role:super-admin|administrador']);

    Route::get('/pedidos', Pedido::class)->name('pedidos.index')->middleware(['role:super-admin|administrador|chofer|jefe mecanicos']);

    Route::get('/pedidos/{pedido}', Solicitud::class)->name('pedido.show')->middleware(['role:super-admin|administrador|chofer|jefe mecanicos']);

});

Route::group(['middleware' => 'auth', 'prefix' => 'logistica'], function() {

    Route::get('/transportes', Transporte::class)->name('transportes.index')->middleware(['role:super-admin|administrador|chofer|jefe mecanicos']);

    Route::get('/taller', Taller::class)->name('taller.index')->middleware(['role:super-admin|administrador|chofer|jefe mecanicos|mecanico']);

    Route::get('/salida/{pedidoDetalleId}', Diagnostico::class)->name('diagnostico.salida')->middleware(['role:super-admin|jefe mecanicos']);

    Route::get('/corregir/{revisionId}', Corregir::class)->name('corregir')->middleware(['role:super-admin|administrador|chofer|jefe mecanicos|mecanico']);

    Route::get('/todoList/{pedidoDetalleId}', PedidoDetalle::class)->name('todoList')->middleware(['role:super-admin|administrador|chofer|jefe mecanicos|mecanico']);

    Route::get('/revisiones', Revision::class)->name('revisiones.index')->middleware(['role:super-admin|administrador|jefe mecanicos']);

    Route::get('/cotizar/{pedidoDetalle}', Cotizar::class)->name('cotizar')->middleware(['role:super-admin|jefe mecanicos|mecanico']);

    Route::resource('cotizacion', CotizacionController::class)->except(['index','create','store','destroy'])->middleware(['role:super-admin|administrador|jefe mecanicos|mecanico']);

    Route::put('/cotizacion/update/{pedidoDetalleId}', [CotizacionController::class, 'updateCotizacion'])->name('cotizacion.updateCotizacion')->middleware(['role:super-admin|jefe mecanicos|mecanico']);

    Route::get('/aceptarCotizacionManual/{pedido}', [ConfirmationsController::class, 'aceptarCotizacionManual'])->name('pedido.aceptarCotizacionManual')->middleware(['role:super-admin|administrador']);

    Route::get('/rechazarCotizacionManual/{pedido}', [ConfirmationsController::class, 'rechazarCotizacionManual'])->name('pedido.rechazarCotizacionManual')->middleware(['role:super-admin|administrador']);

    Route::get('/cotizacion/edit/{pedido}', CotizacionEdit::class)->name('cotizacion.edit2')->middleware(['role:super-admin|jefe mecanicos|mecanico']);
});