<?php

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
            $table->string('title', 255)->unique();
            $table->string('developer_name', 255);
            $table->string('slug', 35)->unique();
            $table->string('thumbnail', 200);
            $table->string('game_file', 200);
            $table->string('version', 20);
            $table->boolean('beta');
            $table->enum('genre', ['action', 'fps']); //TODO: replace with Game::genres
            $table->string('description', 1000);
            $table->string('controls', 1000);
            $table->integer('likes');
            $table->integer('dislikes');
            $table->integer('views');
            $table->string('email', 254);
            $table->string('private-key', 254);
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
