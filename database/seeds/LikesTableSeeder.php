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
        DB::table('versions')->delete();

        $games = array(
            ['id' => 1,

            ],
            ['id' => 2,

            ],
            ['id' => 3,

            ]
        );

        DB::table('versions')->insert($games);
    }
}
