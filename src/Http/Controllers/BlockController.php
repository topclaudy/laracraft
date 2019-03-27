<?php

namespace Awobaz\Laracraft\Http\Controllers;

use Awobaz\Laracraft\Models\Layout\Block;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BlockController extends Controller
{
    /**
     * List the block.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $blocks = Block::all();

        return response()->json($blocks);
    }

    /**
     * Get a block.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, Block $block)
    {
        return response()->json($block);
    }

    /**
     * Store a block.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $block = new Block();

        $block->name = $request->name;
        $block->type = $request->type;
        $block->description = $request->description;
        $block->resource = $request->resource;

        $block->save();

        return response()->json($block);
    }

    /**
     * Update a block.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \Awobaz\Laracraft\Models\Layout\Block $block
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Block $block)
    {
        $block->name = $request->name;
        $block->type = $request->type;
        $block->description = $request->description;
        $block->resource = $request->resource;

        $block->save();

        return response()->json($block);
    }

    /**
     * Delete a block.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \Awobaz\Laracraft\Models\Layout\Block $block
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Request $request, Block $block)
    {
        $block->delete();

        return response()->json($block);
    }
}
