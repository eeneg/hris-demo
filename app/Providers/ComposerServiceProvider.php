<?php

namespace App\Providers;

use App\Plantilla;
use Illuminate\Support\ServiceProvider;
use View;

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
                'plantillas' => $plantillas,
            ];

            $view->with($data);
        });
    }
}
