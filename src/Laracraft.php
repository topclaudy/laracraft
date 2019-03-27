<?php

namespace Awobaz\Laracraft;

class Laracraft
{
    use AuthorizesRequests;

    /**
     * Get the default JavaScript variables for Laracraft.
     *
     * @return array
     * @throws \Exception
     */
    public static function scriptVariables()
    {
        return [
            'path'     => config('laracraft.path'),
            'timezone' => config('app.timezone'),
        ];
    }
}
