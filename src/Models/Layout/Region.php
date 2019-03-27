<?php

namespace Awobaz\Laracraft\Models\Layout;

use Awobaz\Laracraft\Models\Base;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Region extends Base
{
    use HasSlug;

    protected $table = 'laracraft_layout_regions';

    protected $guarded = [];

    protected $with = ['blocks'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('machine_name')
            ->slugsShouldBeNoLongerThan(50)
            ->usingSeparator('-');
    }

    public function blocks(){
        return $this->belongsToMany(Block::class, 'laracraft_layout_region_block')->withTimestamps()->withPivot('order', 'settings')->using(RegionBlock::class)->orderBy('order');
    }
}
