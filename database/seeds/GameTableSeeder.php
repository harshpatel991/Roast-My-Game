<?php

use Illuminate\Database\Seeder;

class GameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('games')->delete();

        $games = array(
            ['id' => 1,
                'user_id' => 2,
                'title' => 'Test Cool Game',
                'slug' => 'test-game',
                'developer' => 'Test Developer',
                'thumbnail' => 'thumb-main.png',
                'genre' => 'action',
                'description' => 'This is a description. This is a description. This is a description. This is a description. This is a description. This is a description.',
                'likes' => 239,
                'views' => 1020,
                'platforms' => "platform-pc,platform-android,platform-html5",

                'link_website' => 'http://website.com',
                'link_twitter' => 'http://twitter.com',
                'link_youtube' => 'http://twitter.com',
                'link_google_plus' => 'http://plus.google.com',
                'link_twitch' => 'http://twitch.com',
                'link_facebook' => 'http://facebook.com',
                'link_google_play' => 'http://play.google.com',
                'link_app_store' => 'http://itunes.apple.com',
                'link_windows_store' => 'http://microsoft.com',
                'link_steam' => 'http://store.steampowered.com',


            ]
        );

        // Uncomment the below to run the seeder
        DB::table('games')->insert($games);
    }
}
