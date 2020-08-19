<?php

namespace Antares\Picklist\Api\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PicklistApiServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFile('picklist_api');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(ai_picklist_api_path('lang'), 'picklist_api');

        $this->loadRoutes();
    }

    protected function mergeConfigFile($name)
    {
        $targetFile = ai_picklist_api_path("config/{$name}.php");

        if (is_file($targetFile) and !Config::has($name)) {
            $this->mergeConfigFrom($targetFile, $name);
        }
    }

    protected function loadRoutes()
    {
        $attributes = [
            'prefix' => config('picklist_api.route.prefix.api'),
            'namespace' => 'Antares\Picklist\Api\Http\Controllers',
        ];
        Route::group($attributes, function () {
            $this->loadRoutesFrom(ai_picklist_api_path('routes/api.php'));
        });
    }
}
