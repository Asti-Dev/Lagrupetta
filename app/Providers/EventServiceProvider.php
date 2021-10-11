<?php

namespace App\Providers;

use App\Events\ProcesarNotificacion;
use App\Listeners\EnviarNotificacion;
use App\Listeners\SetEmpleadoIdSession;
use App\Models\PedidoLog;
use App\Observers\BellNotificationObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            SetEmpleadoIdSession::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            ProcesarNotificacion::class,
            [EnviarNotificacion::class, 'handle']
        );
    }
}
