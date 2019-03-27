<?php

namespace Awobaz\Laracraft\View\Compilers\Concerns;


trait CompilesLayouts
{
    /**
     * Compile the theme statements into valid PHP.
     *
     * @param  string  $theme
     * @return string
     */
    protected function compileTheme($theme)
    {
        $theme = $this->stripParentheses($theme);

        $this->footer[] = "<?php echo \$__env->make('laracraft::renderer', \Illuminate\Support\Arr::except(array_merge(get_defined_vars(), ['theme' => ".$theme."]), ['__data', '__path']))->render(); ?>";

        return '';
    }

    /**
     * Compile the region statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileRegion($expression)
    {
        return "<?php echo \$__env->yieldContent{$expression}; ?>";
    }

    /**
     * Compile the block statements into valid PHP.
     *
     * @param  string  $expression
     * @return string
     */
    protected function compileBlock($expression)
    {
        return "<?php echo \$__env->yieldBlock{$expression}; ?>";
    }
}
