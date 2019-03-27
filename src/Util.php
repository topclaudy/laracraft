<?php

namespace Awobaz\Laracraft;

use Awobaz\Laracraft\View\Contract\Blockable;
use Exception;
use Illuminate\Cache\Repository;
use TheCodingMachine\ClassExplorer\Glob\GlobClassExplorer;

class Util
{
    public static function getDefinedBlockComponents(){
        $components = collect();

        try {
            $componenentNamespaces = config('laracraft.block_component_namespaces') ?: [];

            foreach($componenentNamespaces as $namespace) {
                $explorer = new GlobClassExplorer($namespace, new Repository(cache()->getStore()), 0);
                $componentClassess = $explorer->getClasses();

                foreach ($componentClassess as $class) {
                    $component = resolve($class);

                    if ($component instanceof Blockable) {
                        $components->push($component);
                    }
                }
            }

        } catch(Exception $e){}

        return $components;
    }
}