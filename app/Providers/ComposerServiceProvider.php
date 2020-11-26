<?php

namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;
use App\Plantilla;

class ComposerServiceProvider extends ServiceProvider
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
        View::composer('*', function ($view) {
            $plantillas = Plantilla::orderBy('date_prepared');

            $data = [
                'plantillas' => $plantillas
            ];

            $view->with($data);
        });
    }
}
