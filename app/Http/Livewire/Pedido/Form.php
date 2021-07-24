<?php

namespace App\Http\Livewire\Pedido;

use App\Mail\MailSolicitud;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Bicicleta;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Pedido;
use App\Models\PedidoEstado;
use App\Models\Transporte;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class Form extends Component
{
    public $cliente;
    public $clientes = [];
    public $check;
    public $chofer;
    public $chofers = [];
    public $bicicleta;
    public $bicicletas = [];
    public $fechaRecojoAprox;
    public $observacion;
    public $direccion;

    protected $rules = [
        'cliente' => 'required',
        'bicicleta' => 'required',
        'chofer' => 'required',
        'fechaRecojoAprox' => 'required',
    ];

    
    public function store()
    {
        $cliente = Cliente::where('nombre_apellido', '=', $this->cliente)->first();
        
        $chofer = Empleado::where('nombre_apellido','=', $this->chofer)->first();

        $pedido = Pedido::create([
            'pedido_estado_id' => PedidoEstado::where('nombre','SOLICITADO')->first()->id,
            'cliente_id' => $cliente->id,
            'bicicleta_id' => $this->bicicleta,
            'fecha_recojo_aprox' => $this->fechaRecojoAprox,
            'observacion_cliente' => $this->observacion,
            'confirmacion' => Pedido::ESTADOS[1]
        ]);

        $transporte = Transporte::create([
            'chofer' => $chofer->id,
            'pedido_id' => $pedido->id,
            'ruta' => Transporte::RUTA[1],
            'direccion' => $this->direccion
        ]);

        $url['aceptar'] = URL::temporarySignedRoute(
            'pedido.aceptarSolicitud', now()->addMinutes(60), ['pedido' => $pedido->id]
        );

        $url['rechazar'] = URL::temporarySignedRoute(
            'pedido.rechazarSolicitud', now()->addMinutes(60), ['pedido' => $pedido->id]
        );

        try{
            Mail::to($pedido->cliente->email)
            ->send(new MailSolicitud($pedido, $url));
        }
        catch(\Exception $e){ // Using a generic exception
            session()->flash('danger', 'Email no enviado!');
        }

        session()->flash('success', 'pedido creado!');

        return redirect()->route('pedidos.index');
        

    }

    public function updatedChofer()
    {
        if($this->chofer != ""){
        $this->chofers = Empleado::where([
            ['cargo','=','chofer'],
            ["nombre_apellido", "like","%" . trim($this->chofer) . "%"]
            ])->take(10)
            ->get();
        }else{
            $this->chofers = [];
        }

    }

    public function updatedCliente()
    {
        if($this->cliente != ""){
        $this->clientes = Cliente::where('nombre_apellido', 'like', "%" . trim($this->cliente) . "%")
            ->take(10)
            ->get();

        $this->check = Cliente::where('nombre_apellido', '=', $this->cliente)->first();
        
        }else{
            $this->clientes = [];
        }
        if(!empty($this->check)) {
        $this->direccion = $this->check->direccion;
        }
    }

     
    public function render()
    {
        if(!empty($this->check)) {
            // dd(Cliente::where('id','=',10)->first()->bicicletas()->get());
            $this->bicicletas =  Bicicleta::where('cliente_id','=',$this->check->id)->get();
            
        }
        return view('livewire.pedido.form');
    }
}
