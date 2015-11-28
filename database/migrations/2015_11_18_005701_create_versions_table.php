<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->string('version', 255);
            $table->boolean('beta');
            $table->string('video_link', 255);
            $table->string('image1', 255);
            $table->string('image2', 255);
            $table->string('image3', 255);
            $table->string('image4', 255);

            $table->string('upcoming_features', 1000);
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
        Schema::drop('versions');
    }
}
