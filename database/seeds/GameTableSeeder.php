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
                'title' => 'Test Cool Game',
                'developer_name' => 'Test Developer',
                'slug' => 'test-game',
                'thumbnail' => 'test-image',
                'game_file' => 'test-game-file',
                'version' => '1.2.4',
                'beta' => false,
                'genre' => 'action',
                'description' => 'This is a description. This is a description. This is a description. This is a description. This is a description. This is a description.',
                'controls' => 'This is controls. This is controls. This is controls. This is controls. This is controls. This is controls. This is controls. This is controls. This is controls.',
                'likes' => 239,
                'dislikes' => 491,
                'views' => 1020,
                'email' => 'testemail@gmailc.com',
                'private-key' => '482dfjJj39dJb02101bnA',
                'created_at' => '2015-08-19 03:25:43',
                'updated_at' => '2015-08-20 03:25:43'
            ]
        );

        // Uncomment the below to run the seeder
        DB::table('games')->insert($games);
    }
}
