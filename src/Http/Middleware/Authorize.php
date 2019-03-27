<?php

namespace Awobaz\Laracraft\Http\Middleware;

use Awobaz\Laracraft\Laracraft;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return Laracraft::check($request) ? $next($request) : abort(403);
    }
}
