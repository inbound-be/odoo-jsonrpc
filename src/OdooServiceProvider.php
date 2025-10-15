<?php


namespace Obuchmann\OdooJsonRpc;

use Illuminate\Support\ServiceProvider;
use Obuchmann\OdooJsonRpc\Odoo\Config;
use Obuchmann\OdooJsonRpc\Odoo\Context;
use Obuchmann\OdooJsonRpc\Odoo\OdooModel;


class OdooServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        OdooModel::boot($this->app->make(Odoo::class));
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/odoo.php', 'odoo');

        // Register the service the package provides.
        $this->app->singleton(Odoo::class, function ($app) {
            $config = new Config(
                config('odoo.database', ''),
                config('odoo.host', ''),
                config('odoo.username', ''),
                config('odoo.password', ''),
                config('odoo.ssl_verify', true)
            );
            
            $context = new Context(
                config('odoo.context.lang', null),
                config('odoo.context.timezone', null),
                config('odoo.context.companyId', null)
            );
            
            return new Odoo($config, $context);
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['odoo'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/odoo.php' => config_path('odoo.php'),
        ], 'config');

    }
}