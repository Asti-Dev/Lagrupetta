<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShowPedido extends Component
{

    public $pedido;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.show-pedido');
    }
}
