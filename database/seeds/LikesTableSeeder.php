<?php

use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('likes')->delete();

        $games = array(
            ['id' => 1,
                'user_id' => 1,
                'game_id' => 1
            ],
            ['id' => 2,
                'user_id' => 1,
                'game_id' => 2
            ],
            ['id' => 3,
                'user_id' => 2,
                'game_id' => 2,
            ],
            ['id' => 4,
                'user_id' => 2,
                'game_id' => 3,
            ]
        );

        DB::table('likes')->insert($games);
    }
}
