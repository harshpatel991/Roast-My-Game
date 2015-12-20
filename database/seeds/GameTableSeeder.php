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
                'title' => 'Test Game 1',
                'slug' => 'test-game-1',
                'genre' => 'action',
                'description' => 'This is a description. This is a description. This is a description. This is a description. This is a description. This is a description.',
                'likes' => 239,
                'views' => 1020,
                'platforms' => "platform_pc,platform_android,platform_other",
                'link_platform_pc' => 'http://pc.com',
                'link_platform_mac' => null,
                'link_platform_ios' => null,
                'link_platform_android' => 'http://android.com',
                'link_platform_unity' => null,
                'link_platform_other' => 'http://other-web.com',

                'link_social_greenlight' => 'http://greenlight.com',
                'link_social_website' => 'http://website.com',
                'link_social_twitter' => 'http://link-twitter.com',
                'link_social_youtube' => 'http://link-youtube.com',
                'link_social_google_plus' => 'http://link-gplus.com',
                'link_social_facebook' => 'http://link-facebook.com'

            ],
            [
                'id' => 2,
                'user_id' => 1,
                'title' => 'Test Game 2',
                'slug' => 'test-game-2',
                'genre' => 'shooter',
                'description' => 'This my description',
                'likes' => 50000,
                'views' => 600000,
                'platforms' => "",

                'link_platform_pc' => null,
                'link_platform_mac' => null,
                'link_platform_ios' => null,
                'link_platform_android' => null,
                'link_platform_unity' => null,
                'link_platform_other' => null,

                'link_social_greenlight' => 'http://greenlight.com',
                'link_social_website' => 'http://website.com',
                'link_social_twitter' => 'http://link-twitter.com',
                'link_social_youtube' => null,
                'link_social_google_plus' => null,
                'link_social_facebook' => null
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'title' => 'Test Game 3',
                'slug' => 'test-game-3',
                'genre' => 'strategy',
                'description' => 'This is a teeny tiny description',
                'likes' => 54,
                'views' => 764,
                'platforms' => "",
                'link_platform_pc' => null,
                'link_platform_mac' => null,
                'link_platform_ios' => null,
                'link_platform_android' => null,
                'link_platform_unity' => null,
                'link_platform_other' => null,

                'link_social_greenlight' => null,
                'link_social_website' => null,
                'link_social_twitter' => null,
                'link_social_youtube' => null,
                'link_social_google_plus' => null,
                'link_social_facebook' => null
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'title' => 'Test Game 4',
                'slug' => 'test-game-4',
                'genre' => 'puzzle',
                'description' => 'This is a short description.',
                'likes' => 85423,
                'views' => 887,
                'platforms' => "platform_pc,platform_mac,platform_unity,platform_other,platform_ios,platform_android",
                'link_platform_pc' => null,
                'link_platform_mac' => null,
                'link_platform_ios' => null,
                'link_platform_android' => null,
                'link_platform_unity' => null,
                'link_platform_other' => null,

                'link_social_greenlight' => null,
                'link_social_website' => null,
                'link_social_twitter' => null,
                'link_social_youtube' => null,
                'link_social_google_plus' => null,
                'link_social_facebook' => null
            ],
            [
                'id' => 5,
                'user_id' => 2,
                'title' => 'Test Game 5',
                'slug' => 'test-game-5',
                'genre' => 'strategy',
                'description' => 'This is a teeny tiny description',
                'likes' => 54,
                'views' => 764,
                'platforms' => "",
                'link_platform_pc' => null,
                'link_platform_mac' => null,
                'link_platform_ios' => null,
                'link_platform_android' => null,
                'link_platform_unity' => null,
                'link_platform_other' => null,

                'link_social_greenlight' => null,
                'link_social_website' => null,
                'link_social_twitter' => null,
                'link_social_youtube' => null,
                'link_social_google_plus' => null,
                'link_social_facebook' => null
            ],

        );

        // Uncomment the below to run the seeder
        DB::table('games')->insert($games);
    }
}
