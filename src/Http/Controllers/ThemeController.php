<?php

namespace Awobaz\Laracraft\Http\Controllers;

use Awobaz\Laracraft\Models\Layout\Theme;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ThemeController extends Controller
{
    /**
     * List the themes.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $themes = Theme::all();

        return response()->json($themes);
    }

    /**
     * Get a theme.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \Awobaz\Laracraft\Models\Layout\Theme $theme
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, Theme $theme)
    {
        return response()->json($theme);
    }

    /**
     * Configure a theme.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \Awobaz\Laracraft\Models\Layout\Theme $theme
     * @return \Illuminate\Http\JsonResponse
     */
    public function configure(Request $request, Theme $theme)
    {
        $payload = (object) $request->all();

        foreach($payload->regions as $r){
            $region = $theme->regions()->where('id', $r['id'])->first();

            if($region){
                $blockIds = array_map(function($block){
                    return $block['id'];
                }, $r['blocks']);

                $blocks = array_combine($blockIds, array_map(function($block){
                    return ['order' => $block['order'], 'settings' => json_encode($block['settings'])];
                }, $r['blocks']));

                $region->blocks()->sync($blocks);
            }
        }

        $theme->refresh();

        return response()->json($theme);
    }
}
