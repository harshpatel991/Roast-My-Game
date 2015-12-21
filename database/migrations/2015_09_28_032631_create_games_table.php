<?php

use App\Game;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');;
            $table->string('title', 255);
            $table->string('slug', 35)->unique();
            $table->enum('genre', Game::$genres);
            $table->string('description', 1000);
            $table->integer('likes')->default(0);
            $table->integer('views')->default(0);

            $table->string('platforms', 140)->nullable();
            $table->string('link_platform_pc', 255)->nullable();
            $table->string('link_platform_mac', 255)->nullable();
            $table->string('link_platform_ios', 255)->nullable();
            $table->string('link_platform_android', 255)->nullable();
            $table->string('link_platform_unity', 255)->nullable();
            $table->string('link_platform_other', 255)->nullable();

            $table->string('link_social_greenlight', 255)->nullable();
            $table->string('link_social_website', 255)->nullable();
            $table->string('link_social_twitter', 255)->nullable();
            $table->string('link_social_youtube', 255)->nullable();
            $table->string('link_social_google_plus', 255)->nullable();
            $table->string('link_social_facebook', 255)->nullable();

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
        Schema::drop('games');
    }
}
