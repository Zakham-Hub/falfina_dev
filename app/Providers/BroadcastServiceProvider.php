<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Broadcast::routes();
        Broadcast::routes(['middleware' => ['web', 'auth:admin,manager']]);
        require base_path('routes/channels.php');
    }
}
