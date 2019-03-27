<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laracraft_layout_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('machine_name');
            $table->text('description')->nullable();
            $table->string('type');
            $table->text('resource');
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
        Schema::dropIfExists('laracraft_layout_blocks');
    }
}
