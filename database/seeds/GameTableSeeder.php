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
                'user_id' => 1,
                'title' => 'Test Cool Game',
                'slug' => 'test-game',
                'genre' => 'action',
                'description' => 'This is a description. This is a description. This is a description. This is a description. This is a description. This is a description.',
                'likes' => 239,
                'views' => 1020,
                'platforms' => "platform_pc,platform_android,platform_windows_store",
                'link_social_website' => 'http://website.com',
                'link_social_twitter' => 'http://twitter.com',
                'link_social_youtube' => 'http://youtube.com',
                'link_social_google_plus' => 'http://plus.google.com',
                'link_social_facebook' => 'http://facebook.com'

            ]
        );

        // Uncomment the below to run the seeder
        DB::table('games')->insert($games);
    }
}
