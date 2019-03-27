<?php

namespace Awobaz\Laracraft\Models;

use Jenssegers\Model\Model as BaseModel;

class StdModel extends BaseModel
{
    public static function create($attributes = [])
    {
        $model = new static($attributes);

        return $model;
    }
}