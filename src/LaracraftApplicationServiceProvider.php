<?php

namespace Awobaz\Laracraft;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class LaracraftApplicationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->authorization();
    }

    /**
     * Configure the Laracraft authorization services.
     *
     * @return void
     */
    protected function authorization()
    {
        $this->gate();

        Laracraft::auth(function ($request) {
            return app()->environment('local') || Gate::check('viewLaracraft', [$request->user()]);
        });
    }

    /**
     * Register the Laracraft gate.
     *
     * This gate determines who can access Laracraft in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewLaracraft', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
