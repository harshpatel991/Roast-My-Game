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
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games');;
            $table->string('version', 255);
            $table->string('slug', 35);
            $table->boolean('beta');
            $table->string('video_link', 255)->nullable();
            $table->string('image1', 255);
            $table->string('image2', 255)->nullable();
            $table->string('image3', 255)->nullable();
            $table->string('image4', 255)->nullable();

            $table->string('link_platform_pc', 255)->nullable();
            $table->string('link_platform_mac', 255)->nullable();
            $table->string('link_platform_ios', 255)->nullable();
            $table->string('link_platform_android', 255)->nullable();
            $table->string('link_platform_unity', 255)->nullable();
            $table->string('link_platform_other', 255)->nullable();

            $table->string('upcoming_features', 1000);
            $table->string('changes', 1000);
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
