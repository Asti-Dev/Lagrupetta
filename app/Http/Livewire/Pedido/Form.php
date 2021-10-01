<?php

namespace App\Http\Livewire\Pedido;

use App\Mail\MailSolicitud;
use App\Models\Bicicleta;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\ParteModelo;
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
    public $distrito;
    public $rango;
    public $distritos = Cliente::DISTRITOS;

    protected $rules = [
        'cliente' => 'required',
        'rango' => 'require',
        'bicicleta' => 'required',
        'chofer' => 'required',
        'direccion' => 'required',
        'distrito' => 'required',
        'fechaRecojoAprox' => 'required',
    ];

    public function mount(Cliente $cliente)
    {
        $this->cliente = $cliente->nombre_apellido ?? '';
        if (!empty($this->cliente)) {
            $this->direccion = $cliente->direccion;
            $this->bicicletas = $cliente->bicicletas;
            $this->distrito = $cliente->distrito;
        }
    }

    public function store()
    {
        $cliente = Cliente::where('nombre_apellido', '=', $this->cliente)->first();
        
        $chofer = Empleado::where('nombre_apellido','=', $this->chofer)->first();

        $bicicleta = Bicicleta::find($this->bicicleta);

        $parteModelos = ParteModelo::all();

        if(
            $bicicleta->parteModelos()->count() != $parteModelos->count()
        ){
            foreach ($parteModelos as $parteModelo ) {
                $bicicleta->parteModelos()->sync( $parteModelo->id, false);
            }
            
        }

        $pedido = Pedido::create([
            'pedido_estado_id' => PedidoEstado::where('nombre','EN RUTA RECOJO')->first()->id,
            'cliente_id' => $cliente->id,
            'bicicleta_id' => $this->bicicleta,
            'fecha_recojo_aprox' => $this->fechaRecojoAprox,
            'observacion_cliente' => $this->observacion,
            'rango_recojo' => $this->rango,
        ]);

        $pedido->transportes()->create([
            'chofer' => $chofer->id,
            'ruta' => Transporte::RUTA[1],
            'direccion' => $this->direccion,
            'distrito' => $this->distrito,
        ]);

        $url['aceptar'] = URL::temporarySignedRoute(
            'pedido.aceptarSolicitud', now()->addMinutes(300), ['pedido' => $pedido->id]
        );

        $url['rechazar'] = URL::temporarySignedRoute(
            'pedido.rechazarSolicitud', now()->addMinutes(300), ['pedido' => $pedido->id]
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
        $this->distrito = $this->check->distrito;
        }
    }

     
    public function render()
    {
        $this->chofers = Empleado::where([['cargo','=','chofer']])->get();
        if(!empty($this->check)) {
            // dd(Cliente::where('id','=',10)->first()->bicicletas()->get());
            $this->bicicletas =  Bicicleta::where('cliente_id','=',$this->check->id)->get();
            
        }
        return view('livewire.pedido.form');
    }
}
