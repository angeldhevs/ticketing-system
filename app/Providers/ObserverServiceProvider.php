<?php

namespace App\Providers;

use App\Models\Manage\User;
use Illuminate\Support\ServiceProvider;
use App\Models\Ticket\Ticket;
use App\Observers\UserObserver;
use App\Observers\TicketObserver;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Ticket::observe(TicketObserver::class);
    }
}
