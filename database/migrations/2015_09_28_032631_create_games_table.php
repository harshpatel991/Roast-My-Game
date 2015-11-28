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
            $table->integer('user_id');
            $table->string('title', 255)->unique();
            $table->string('slug', 35)->unique();
            $table->string('developer', 255);
            $table->enum('genre', Game::$genres);
            $table->string('description', 1000);
            $table->integer('likes');
            $table->integer('views');
            $table->string('platforms', 140);

            $table->string('link_website', 255);
            $table->string('link_twitter', 255);
            $table->string('link_youtube', 255);
            $table->string('link_google_plus', 255);
            $table->string('link_twitch', 255);
            $table->string('link_facebook', 255);
            $table->string('link_google_play', 255);
            $table->string('link_app_store', 255);
            $table->string('link_windows_store', 255);
            $table->string('link_steam', 255);

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
