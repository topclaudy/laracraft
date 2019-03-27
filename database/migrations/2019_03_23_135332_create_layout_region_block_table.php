<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutRegionBlockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laracraft_layout_region_block', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('region_id')->unsigned()->foreign('region_id')->references('id')->on('laracraft_layout_regions')->onDelete('CASCADE');
            $table->integer('block_id')->unsigned()->foreign('block_id')->references('id')->on('laracraft_layout_blocks')->onDelete('CASCADE');
            $table->integer('order')->default(0);
            $table->json('settings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laracraft_layout_region_block');
    }
}
