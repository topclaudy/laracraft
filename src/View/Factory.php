<?php

namespace Awobaz\Laracraft\View;

use Awobaz\Laracraft\View\Concerns\ManagesLayouts;
use Illuminate\View\Factory as BaseFactory;

class Factory extends BaseFactory
{
    use ManagesLayouts;
}