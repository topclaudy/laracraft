<?php

namespace Awobaz\Laracraft\View\Contract;

use Illuminate\Contracts\Support\Htmlable;

interface Blockable extends Htmlable
{
    public function name(): string;
    public function description(): string;
}