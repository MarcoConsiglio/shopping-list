<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Aggiorna i driver Chrome per Dusk solo per ambienti di test e sviluppo.
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(\Staudenmeir\DuskUpdater\DuskServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
