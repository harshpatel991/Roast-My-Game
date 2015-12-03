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

        $versions = array(
            ['id' => 1,
                'game_id' => 1,
                'version' => '1.2.3',
                'slug' => '1.2.3',
                'beta' => true,
                'video_link' => 'https://www.youtube.com/watch?v=e-ORhEE9VVg',
                'image1' => 'test-image1.png',
                'image2' => 'test-image2.png',
                'image3' => 'test-image3.png',
                'image4' => 'test-image3-2.png',
                'upcoming_features' => "Upcomming feaures 1.2.3",
                'changes' => "Changes made this version in 1.2.3"
            ],
            ['id' => 2,
                'game_id' => 1,
                'version' => '1.2.5',
                'slug' => '1.2.5',
                'beta' => true,
                'video_link' => 'https://www.youtube.com/watch?v=WA4iX5D9Z64',
                'image1' => 'test-image4.png',
                'image2' => 'test-image5.png',
                'image3' => 'test-image6.png',
                'image4' => '',
                'upcoming_features' => "Upcomming feaures 1.2.5",
                'changes' => "Changes made this version in 1.2.5"
            ],
            ['id' => 3,
                'game_id' => 1,
                'version' => '1.1.1',
                'slug' => '1.1.1',
                'beta' => true,
                'video_link' => '',
                'image1' => 'test-image7.png',
                'image2' => 'test-image8.png',
                'image3' => 'test-image9.png',
                'image4' => '',
                'upcoming_features' => "Upcomming feaures 1.1.1",
                'changes' => ''
            ]
        );

        DB::table('versions')->insert($versions);
    }
}
