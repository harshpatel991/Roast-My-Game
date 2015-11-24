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

                'link-website' => 'http://website.com',
                'link-twitter' => 'http://twitter.com',
                'link-youtube' => 'http://twitter.com',
                'link-google-plus' => 'http://plus.google.com',
                'link-twitch' => 'http://twitch.com',
                'link-facebook' => 'http://facebook.com',
                'link-google-play' => 'http://play.google.com',
                'link-app-store' => 'http://itunes.apple.com',
                'link-windows-store' => 'http://microsoft.com',
                'link-steam' => 'http://store.steampowered.com',


            ]
        );

        // Uncomment the below to run the seeder
        DB::table('games')->insert($games);
    }
}
