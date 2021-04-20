<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Test extends Component
{
    public $estados = [
        'ACEPTADO' => 'success',
        'EN ESPERA' => 'warning',
        'RECHAZADO' => 'danger',
        'COMPLETADO' => 'success',
        'FALLIDO' => 'danger'
    ];

    public $estado;
    public $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($estado)
    {
        $this->color = $this->estados[$estado];
        $this->estado = $estado;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.test');
    }
}
