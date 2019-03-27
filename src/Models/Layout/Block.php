<?php

namespace Awobaz\Laracraft\Models\Layout;

use Awobaz\Laracraft\Models\Base;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Block extends Base
{
    use HasSlug;

    protected $table = 'laracraft_layout_blocks';

    protected $guarded = [];

    const TYPE_COMPONENT = 'component';
    const TYPE_IMAGE = 'image';
    const TYPE_WYSIWYG = 'wysiwyg';

    const TYPES = [
        self::TYPE_COMPONENT,
        self::TYPE_IMAGE,
        self::TYPE_WYSIWYG
    ];

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

    public function regions(){
        return $this->belongsToMany(Region::class, 'laracraft_layout_region_block')->withTimestamps()->withPivot('order', 'settings')->using(RegionBlock::class)->orderBy('name');
    }
}
