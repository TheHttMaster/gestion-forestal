<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Spatie\Activitylog\Models\Activity;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Escuchar el evento de inicio de sesión
        Event::listen(function (Login $event) {
            activity()
                ->causedBy($event->user) // El usuario que ha iniciado sesión
                ->log('ha iniciado sesión');
        });

        // Escuchar el evento de cierre de sesión
        Event::listen(function (Logout $event) {
            activity()
                ->causedBy($event->user) // El usuario que ha cerrado sesión
                ->log('ha cerrado sesión');
        });
    }
}
