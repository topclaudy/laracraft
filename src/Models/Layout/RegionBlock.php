<?php

namespace Awobaz\Laracraft\Models\Layout;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RegionBlock extends Pivot
{
    protected $attributes = [
        'settings' => '{}'
    ];
}
