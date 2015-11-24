<?php

use Illuminate\Database\Seeder;

class VersionTableSeeder extends Seeder
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
                'game_id' => 1,
                'version' => '1.2.3',
                'beta' => true,
                'image1' => 'test-image1.png',
                'image2' => 'test-image2.png',
                'image3' => 'test-image3.png',
                'upcoming_features' => "Upcomming feaures 1.2.3"
            ],
            ['id' => 2,
                'game_id' => 1,
                'version' => '1.2.5',
                'beta' => true,
                'image1' => 'test-image4.png',
                'image2' => 'test-image5.png',
                'image3' => 'test-image6.png',
                'upcoming_features' => "Upcomming feaures 1.2.5"
            ],
            ['id' => 3,
                'game_id' => 1,
                'version' => '1.1.1',
                'beta' => true,
                'image1' => 'test-image7.png',
                'image2' => 'test-image8.png',
                'image3' => 'test-image9.png',
                'upcoming_features' => "Upcomming feaures 1.1.1"
            ]
        );

        DB::table('versions')->insert($games);
    }
}
