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
            $table->string('thumbnail', 200);
            $table->enum('genre', Game::$genres);
            $table->string('description', 1000);
            $table->integer('likes');
            $table->integer('views');
            $table->string('platforms', 140);

            $table->string('link-website', 255);
            $table->string('link-twitter', 255);
            $table->string('link-youtube', 255);
            $table->string('link-google-plus', 255);
            $table->string('link-twitch', 255);
            $table->string('link-facebook', 255);
            $table->string('link-google-play', 255);
            $table->string('link-app-store', 255);
            $table->string('link-windows-store', 255);
            $table->string('link-steam', 255);

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
