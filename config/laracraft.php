<?php

use Awobaz\Laracraft\Http\Middleware\Authorize;

return [
    /*
    |--------------------------------------------------------------------------
    | Themes locations, relative to /resources/views
    | Add your own paths to this list or change any of
    | the existing paths. Or, you can simply stick with this list.
    |--------------------------------------------------------------------------
    |
    */
    'theme_paths' => [
        'themes',
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespace where block components are located
    | Add your own namespaces to this list or change any of
    | the existing middleware. Or, you can simply stick with this list.
    |--------------------------------------------------------------------------
    |
    */
    'block_component_namespaces' => [
        "App\Block\Components",
    ],

    /*
    |--------------------------------------------------------------------------
    | Base url path of the admin panel
    |--------------------------------------------------------------------------
    |
    */
    'path'        => 'laracraft',

    /*
    |--------------------------------------------------------------------------
    | Laracraft Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be assigned to every Laracraft route, giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with this list.
    |
    */
    'middlewares' => [
        'web',
        Authorize::class,
    ],
];
