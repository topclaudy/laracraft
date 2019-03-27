<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laracraft_layout_regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('theme_id')->foreign('theme_id')->references('id')->on('laracraft_layout_themes')->onDelete('CASCADE');
            $table->string('name');
            $table->string('machine_name');
            $table->unique(['theme_id', 'name']);
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
        Schema::dropIfExists('laracraft_layout_regions');
    }
}
