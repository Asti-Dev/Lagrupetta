<?php

namespace App\Http\Livewire\Pedido\Solicitud;

use App\Mail\MailSolicitud;
use App\Models\Bicicleta;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Pedido;
use App\Models\Transporte;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Form extends Component
{
    public Pedido $pedido;
    public $cliente;
    public $clientes = [];
    public $check;
    public $chofer;
    public $chofers = [];
    public Bicicleta $bicicleta;
    public $bicicletas = [];
    public $fechaRecojoAprox;
    public $observacion;
    public $confirmacion;
    public $estados = [];



    public function mount()
    {
        $this->cliente = $this->pedido->cliente->user->email;
        $this->chofer = $this->pedido->transporteRecojo()->choferTransporte->nombre_apellido;
        $this->bicicleta = $this->pedido->bicicleta;
        $this->fechaRecojoAprox = date('Y-m-d',strtotime($this->pedido->fecha_recojo_aprox)) ;
        $this->observacion = $this->pedido->observacion_cliente;
        $this->confirmacion = $this->pedido->confirmacion;
        $this->estados = Pedido::ESTADOS;
    }
    public function rules()
    {
        return [
            'cliente' => 'required',
            'bicicleta.id' => 'required',
            'chofer' => 'required',
            'confirmacion' => Rule::in(Pedido::ESTADOS),
        ];
    }

    public function update()
    {
        $cliente = Cliente::whereHas('user', function (Builder $query) {
            $query->where('email', '=', $this->cliente);
        })->first();

        $chofer = Empleado::where('nombre_apellido', '=', $this->chofer)->first();

        $this->fechaRecojoAprox = $this->fechaRecojoAprox ?? $this->pedido->fecha_recojo_aprox;

        $this->pedido->update([
            'cliente_id' => $cliente->id,
            'bicicleta_id' => $this->bicicleta->id,
            'fecha_recojo_aprox' => $this->fechaRecojoAprox,
            'observacion_cliente' => $this->observacion,
            'confirmacion' => $this->confirmacion,
        ]);

        $transporte = Transporte::find($this->pedido->transporteRecojo()->id);

        $transporte->update([
            'chofer' => $chofer->id,
        ]);

        $url['aceptar'] = URL::temporarySignedRoute(
            'pedido.aceptarSolicitud',
            now()->addMinutes(60),
            ['pedido' => $this->pedido->id]
        );

        $url['rechazar'] = URL::temporarySignedRoute(
            'pedido.rechazarSolicitud',
            now()->addMinutes(60),
            ['pedido' => $this->pedido->id]
        );

        try{
            Mail::to($this->pedido->cliente->user->email)
            ->send(new MailSolicitud($this->pedido, $url));
        }
        catch(\Exception $e){ // Using a generic exception
            session()->flash('danger', 'Email no enviado!');
        }

         session()->flash('success', 'Pedido Actualizado!');

        return redirect()->route('pedidos.index');
}


    public function updatedChofer()
    {
        if ($this->chofer != "") {
            $this->chofers = Empleado::where([
                ['cargo', '=', 'chofer'],
                ["nombre_apellido", "like", "%" . trim($this->chofer) . "%"]
            ])->take(10)
                ->get();
        } else {
            $this->chofers = [];
        }
    }

    public function updatedCliente()
    {
        if ($this->cliente != "") {
            $this->clientes = Cliente::whereHas('user', function (Builder $query) {
                $query->where('email', 'like', "%" . trim($this->cliente) . "%");
            })->take(10)
                ->get();

            $this->check = Cliente::whereHas('user', function (Builder $query) {
                $query->where('email', '=', $this->cliente);
            })->first();
        } else {
            $this->clientes = [];
        }
    }

    public function render()
    {
        if (!empty($this->check)) {
            // dd(Cliente::where('id','=',10)->first()->bicicletas()->get());
            $this->bicicletas =  Bicicleta::where('cliente_id', '=', $this->check->id)->get();
        }
        return view('livewire.pedido.solicitud.form');
    }
}
