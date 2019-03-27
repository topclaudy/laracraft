<?php

namespace Awobaz\Laracraft;

use Awobaz\Laracraft\Console\Commands\Install;
use Awobaz\Laracraft\Console\Commands\Migrate;
use Awobaz\Laracraft\Console\Commands\Publish;
use Awobaz\Laracraft\Console\Commands\InstallThemes;
use Awobaz\Laracraft\Models\Layout\Region;
use Awobaz\Laracraft\View\Compilers\BladeCompiler;
use Awobaz\Laracraft\View\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LaracraftServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        Route::middlewareGroup('laracraft', config('laracraft.middlewares', []));

        $this->registerRoutes();
        $this->registerMigrations();
        $this->registerViews();
        $this->registerPublishing();
        $this->registerViewComposer();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
        $this->mergeConfig();
        $this->registerBladeExtensions();
    }

    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function registerMigrations()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    public function registerViews(){
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laracraft');
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        });
    }

    /**
     * Get the Laracraft route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'namespace'  => 'Awobaz\Laracraft\Http\Controllers',
            'prefix'     => config('laracraft.path'),
            'middleware' => 'laracraft',
        ];
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/laracraft'),
                __DIR__.'/../resources/icons' => resource_path('vendor/laracraft/icons'),
            ], 'laracraft-assets');

            $this->publishes([
                __DIR__.'/../config/laracraft.php' => config_path('laracraft.php'),
            ], 'laracraft-config');

            $this->publishes([
                __DIR__.'/../stubs/LaracraftServiceProvider.stub' => app_path('Providers/LaracraftServiceProvider.php'),
            ], 'laracraft-provider');
        }
    }


    /**
     * Register the application commands.
     *
     * @return void
     */
    private function registerCommands()
    {
        $this->commands([
            Install::class,
            Migrate::class,
            Publish::class,
            InstallThemes::class,
        ]);
    }

    private function mergeConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laracraft.php', 'laracraft');
    }

    /**
     * Register the view environment.
     *
     * @return void
     */
    public function registerFactory()
    {
        $this->app->extend('view', function () {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $this->app['view.engine.resolver'];

            $finder = $this->app['view.finder'];

            $factory = $this->createFactory($resolver, $finder, $this->app['events']);

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $factory->setContainer($this->app);

            $factory->share('app', $this->app);

            return $factory;
        });
    }

    /**
     * Create a new Factory Instance.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @param  \Illuminate\View\ViewFinderInterface  $finder
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return \Illuminate\View\Factory
     */
    protected function createFactory($resolver, $finder, $events)
    {
        return new Factory($resolver, $finder, $events);
    }

    /**
     * Register the Blade engine implementation.
     *
     * @return void
     */
    public function registerBladeEngine()
    {
        // The Compiler engine requires an instance of the CompilerInterface, which in
        // this case will be the Blade compiler, so we'll first create the compiler
        // instance to pass into the engine so it can compile the views properly.
        //
        $this->app->extend('blade.compiler', function () {
            return new BladeCompiler(
                $this->app['files'], $this->app['config']['view.compiled']
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function registerBladeExtensions()
    {
        $this->registerFactory();
        $this->registerBladeEngine();
    }

    /**
     * Register view composer.
     *
     * @return void
     */
    public function registerViewComposer(){
        view()->composer('laracraft::renderer', function($view) {
            //Inject layout regions data
            $view->with('regions', Region::all());
        });
    }
}
