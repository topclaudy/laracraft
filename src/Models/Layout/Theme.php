<?php

namespace Awobaz\Laracraft\Models\Layout;

use Awobaz\Laracraft\Models\Base;

class Theme extends Base
{
    protected $table = 'laracraft_layout_themes';

    protected $with = ['regions'];

    protected $guarded = [];

    protected $appends = ['view'];

    public function regions(){
        return $this->hasMany(Region::class);
    }

    public function getViewAttribute(){
        return str_replace('.blade.php', '', $this->relative_path);
    }
}
