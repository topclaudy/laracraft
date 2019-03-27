<?php

namespace Awobaz\Laracraft;

trait AuthorizesRequests
{
    /**
     * The callback that should be used to authenticate Laracraft users.
     *
     * @var \Closure
     */
    public static $authUsing;

    /**
     * Register the Laracraft authentication callback.
     *
     * @param  \Closure  $callback
     * @return static
     */
    public static function auth($callback)
    {
        static::$authUsing = $callback;

        return new static;
    }

    /**
     * Determine if the given request can access the Laracraft dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function check($request)
    {
        return (static::$authUsing ?: function () {
            return app()->environment('local');
        })($request);
    }
}
