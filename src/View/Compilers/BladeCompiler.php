<?php

namespace Awobaz\Laracraft\View\Compilers;

use Awobaz\Laracraft\View\Compilers\Concerns\CompilesLayouts;
use Illuminate\View\Compilers\BladeCompiler as BaseCompiler;

class BladeCompiler extends BaseCompiler
{
    use CompilesLayouts;
}