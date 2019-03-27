<?php

namespace Awobaz\Laracraft\Http\Controllers;

use Awobaz\Laracraft\Models\StdModel;
use Awobaz\Laracraft\Util;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ComponentController extends Controller
{
    /**
     * List the components.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $componentObjects = Util::getDefinedBlockComponents();

        $components = $componentObjects->map(function($object){
            $component = new StdModel();
            $component->name = $object->name();
            $component->description = $object->description();
            $component->class = get_class($object);

            return $component;
        });

        return response()->json($components);
    }
}
