<?php

namespace App\Http\Livewire\Widget\Notification;

use App\Models\PedidoLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Bell extends Component
{
    public $notificaciones;
    public $notificacionesNoLeidas;
    public $user;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->user =  User::find(Auth::user()->id);
    }

    public function delete(PedidoLog $notificacion){
        $notificacion->usuarios()->detach($this->user->id);
        $this->emitSelf('refresh');
    }

    public function visto(PedidoLog $notificacion){
        $notificacion->usuarios()->updateExistingPivot($this->user->id,['visto' => true], true);
        $this->emitSelf('refresh');
    }

    public function render()
    {
        $this->notificacionesNoLeidas = $this->user->pedidoLogs()->wherePivot('visto', false)->count();
        $this->notificaciones = $this->user->pedidoLogs;

        return view('livewire.widget.notification.bell');
    }
}
