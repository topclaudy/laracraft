<?php

namespace Awobaz\Laracraft\Http\Controllers;

use Awobaz\Laracraft\Laracraft;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    /**
     * Display the Laracraft view.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index()
    {
        return view('laracraft::app', [
            'laracraftScriptVariables' => Laracraft::scriptVariables(),
        ]);
    }
}
