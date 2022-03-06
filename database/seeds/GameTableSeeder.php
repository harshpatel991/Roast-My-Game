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
                'likes' => 1,
                'views' => 1020,
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
                'likes' => 2,
                'views' => 600000,
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
                'likes' => 1,
                'views' => 764,
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
                'likes' => 0,
                'views' => 887,
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
                'likes' => 0,
                'views' => 764,
                'link_social_greenlight' => null,
                'link_social_website' => null,
                'link_social_twitter' => null,
                'link_social_youtube' => null,
                'link_social_google_plus' => null,
                'link_social_facebook' => null
            ],
            [
                'id' => 6,
                'user_id' => 3,
                'title' => 'Test Game 6',
                'slug' => 'test-game-6',
                'genre' => 'strategy',
                'description' => 'text<br /><br />pharagraph text<br /><br /><strong>bold text</strong><br /><br /><em>italics text</em><br /><br /><a href="http://google.com">link</a><br /><br />
                                <ul>
                                <li>bullet1</li>
                                <li>bullet2</li>
                                <li>bullet3</li>
                                </ul>
                                <br />
                                <ol>
                                <li>number1</li>
                                <li>number2</li>
                                <li>number3</li>
                                </ol>',
                'likes' => 0,
                'views' => 764,
                'link_social_greenlight' => null,
                'link_social_website' => null,
                'link_social_twitter' => null,
                'link_social_youtube' => null,
                'link_social_google_plus' => null,
                'link_social_facebook' => null
            ]

        );

        // Uncomment the below to run the seeder
        DB::table('games')->insert($games);
    }
}
