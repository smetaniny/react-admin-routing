<?php

namespace Smetaniny\ReactAdminRouting;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Smetaniny\ReactAdminRouting\Contracts\ResourceShowInterface;
use Smetaniny\ReactAdminRouting\Contracts\RouteHandlerFactoryInterface;
use Smetaniny\ReactAdminRouting\Factories\RouteHandlerFactory;
use Smetaniny\ReactAdminRouting\Middleware\AdminMiddleware;
use Smetaniny\ReactAdminRouting\Middleware\RoleAdminMiddleware;
use Smetaniny\ReactAdminRouting\Services\ResourceShowService;
use Smetaniny\ReactAdminRouting\Services\ResourceStrategyFirstService;
use Smetaniny\ReactAdminRouting\Services\ResourceStrategyGetService;

class ReactAdminRoutingServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // Загрузка маршрутов из файла
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/react-admin-routing.php', 'react-admin-routing');

        // Регистрация Middleware
        $this->app->singleton(AdminMiddleware::class);
        $this->app->singleton(RoleAdminMiddleware::class);

        // Добавление псевдонимов middleware
        $this->app['router']->aliasMiddleware('admin', AdminMiddleware::class);
        $this->app['router']->aliasMiddleware('role', RoleAdminMiddleware::class);

        // Регистрация фабрики обработчиков маршрутов
        $this->app->singleton(RouteHandlerFactoryInterface::class, function ($app) {
            return new RouteHandlerFactory();
        });

        // Регистрация фасада
        $this->app->singleton('RouteHandlerFactory', function ($app) {
            return $app->make(RouteHandlerFactoryInterface::class);
        });

        // Связывает интерфейс ResourceShowInterface с классом ResourceShowService
        $this->app->bind(ResourceShowInterface::class, ResourceShowService::class);

        // Помечает классы ResourceStrategyFirstService и ResourceStrategyGetService тегом 'QueryStrategyInterface'
        $this->app->tag([ResourceStrategyFirstService::class, ResourceStrategyGetService::class], 'QueryStrategyInterface');


    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [RouteHandlerFactoryInterface::class];
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
            __DIR__ . '/../config/react-admin-routing.php' => config_path('react-admin-routing.php'),
        ], 'react-admin-routing.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/smetaniny'),
        ], 'react-admin-routing.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/smetaniny'),
        ], 'react-admin-routing.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/smetaniny'),
        ], 'react-admin-routing.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
