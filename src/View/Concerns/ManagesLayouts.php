<?php

namespace Awobaz\Laracraft\View\Concerns;

use Awobaz\Laracraft\Models\Layout\Block;
use Illuminate\Contracts\Support\Htmlable;
use Parsedown;

trait ManagesLayouts
{
    /**
     * Get the string contents of a block.
     *
     * @param $block
     * @return string
     */
    public function yieldBlock($block)
    {
        $block = Block::whereMachineName($block)->first();

        $blockContent = null;

        switch($block->type){
            case Block::TYPE_COMPONENT:
                $component = resolve($block->resource);

                if($component instanceof Htmlable){
                    $blockContent = $component->toHtml();
                }

                break;

            case Block::TYPE_WYSIWYG:
                $blockContent = $block->resource;

                break;

            case Block::TYPE_MARKDOWN:
                $parser = new Parsedown();
                $blockContent = $parser->text($block->resource);

                break;
        }

        return $blockContent;
    }
}