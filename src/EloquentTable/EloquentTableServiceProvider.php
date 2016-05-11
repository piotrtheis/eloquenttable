<?php

namespace Tysdever\EloquentTable;

use File;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class EloquentTableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request, Registrar $routing, Dispatcher $events)
    {
        if ($this->app->runningInConsole()) {
            $this->defineResources();
        }

        $this->loadResources();

        // Include the helpers so we can output sortable links
        include __DIR__ . '/../../../../stevebauman/eloquenttable/src/helpers.php';

        //load excel
        $this->app->register(\Maatwebsite\Excel\ExcelServiceProvider::class);
        AliasLoader::getInstance()->alias('Excel', \Maatwebsite\Excel\Facades\Excel::class);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Load the resources used by EloquentTable.
     *
     * @return void
     */
    protected function loadResources()
    {
        if (File::exists($path = resource_path('views/vendor/tysdever/eloquenttable'))) {
            $this->loadViewsFrom($path, 'eloquenttable');
        } else {
            $this->loadViewsFrom(__DIR__ . '/../views', 'eloquenttable');
        }

        if (File::exists($path = resource_path('lang/vendor/tysdever/eloquenttable'))) {
            $this->loadTranslationsFrom($path, 'eloquenttable');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../lang', 'eloquenttable');
        }
    }

    /**
     * Define the resources used by EloquentTable.
     *
     * @return void
     */
    protected function defineResources()
    {
        $this->publishes([
            __DIR__ . '/../lang' => resource_path('lang/vendor/tysdever/eloquenttable'),
        ], 'lang');

        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('eloquenttable.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../views' => resource_path('views/vendor/tysdever/eloquenttable'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../assets' => resource_path('assets/vendor/tysdever/eloquenttable'),
        ], 'assets');
    }
}
