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
                'image1' => 'image1.jpg',
                'image2' => 'image2.jpg',
                'image3' => 'image3.jpg',
                'image4' => null,

                'link_platform_pc' => 'http://pc-game-1-version-1.2.3.com',
                'link_platform_mac' => null,
                'link_platform_ios' => null,
                'link_platform_android' => 'http://android-game-1-version-1.2.3.com',
                'link_platform_unity' => null,
                'link_platform_other' => 'http://other-web-game-1-version-1.2.3.com',

                'upcoming_features' => "Upcomming feaures 1.2.3",
                'changes' => "Changes made this version in 1.2.3"
            ],
            ['id' => 2,
                'game_id' => 1,
                'version' => '1.2.5',
                'slug' => '1.2.5',
                'beta' => true,
                'video_link' => 'https://www.youtube.com/watch?v=WA4iX5D9Z64',
                'image1' => 'image4.jpg',
                'image2' => 'image5.jpg',
                'image3' => 'image6.jpg',
                'image4' => null,

                'link_platform_pc' => 'http://pc-game-1-version-1.2.5.com',
                'link_platform_mac' => 'http://mac-game-1-version-1.2.5.com',
                'link_platform_ios' => 'http://ios-game-1-version-1.2.5.com',
                'link_platform_android' => 'http://android-game-1-version-1.2.5.com',
                'link_platform_unity' => 'http://unity-game-1-version-1.2.5.com',
                'link_platform_other' => 'http://other-web-game-1-version-1.2.5.com',

                'upcoming_features' => "Upcomming feaures 1.2.5",
                'changes' => "Changes made this version in 1.2.5"
            ],
            ['id' => 3,
                'game_id' => 1,
                'version' => '1.1.1',
                'slug' => '1.1.1',
                'beta' => true,
                'video_link' => '',
                'image1' => 'image7.jpg',
                'image2' => null,
                'image3' => null,
                'image4' => null,

                'link_platform_pc' => 'http://pc-game-1-version-1.1.1.com',
                'link_platform_mac' => 'http://mac-game-1-version-1.1.1.com',
                'link_platform_ios' => 'http://ios-game-1-version-1.1.1.com',
                'link_platform_android' => 'http://android-game-1-version-1.1.1.com',
                'link_platform_unity' => 'http://unity-game-1-version-1.1.1.com',
                'link_platform_other' => 'http://other-web-game-1-version-1.1.1.com',

                'upcoming_features' => "Upcomming feaures 1.1.1",
                'changes' => ''
            ],
            ['id' => 4,
                'game_id' => 2,
                'version' => '1.1.1',
                'slug' => '1.1.1',
                'beta' => true,
                'video_link' => '',
                'image1' => 'image6.jpg',
                'image2' => null,
                'image3' => null,
                'image4' => null,

                'link_platform_pc' => 'http://pc-game-2-version-1.1.1.com',
                'link_platform_mac' => 'http://mac-game-2-version-1.1.1.com',
                'link_platform_ios' => 'http://ios-game-2-version-1.1.1.com',
                'link_platform_android' => 'http://android-game-2-version-1.1.1.com',
                'link_platform_unity' => 'http://unity-game-2-version-1.1.1.com',
                'link_platform_other' => 'http://other-web-game-2-version-1.1.1.com',


                'upcoming_features' => "Upcomming feaures 1.1.1",
                'changes' => ''
            ],
            ['id' => 5,
                'game_id' => 3,
                'version' => '1.1.1',
                'slug' => '1.1.1',
                'beta' => true,
                'video_link' => '',
                'image1' => 'image5.jpg',
                'image2' => 'image3.jpg',
                'image3' => null,
                'image4' => null,

                'link_platform_pc' => null,
                'link_platform_mac' => null,
                'link_platform_ios' => null,
                'link_platform_android' => null,
                'link_platform_unity' => null,
                'link_platform_other' => null,

                'upcoming_features' => "Upcomming feaures 1.1.1",
                'changes' => ''
            ],
            ['id' => 6,
                'game_id' => 4,
                'version' => '1.1.1',
                'slug' => '1.1.1',
                'beta' => true,
                'video_link' => '',
                'image1' => 'image2.jpg',
                'image2' => 'image3.jpg',
                'image3' => 'image5.jpg',
                'image4' => null,

                'link_platform_pc' => null,
                'link_platform_mac' => null,
                'link_platform_ios' => null,
                'link_platform_android' => null,
                'link_platform_unity' => null,
                'link_platform_other' => null,

                'upcoming_features' => "Upcomming feaures 1.1.1",
                'changes' => ''
            ],
            ['id' => 7,
                'game_id' => 5,
                'version' => '1.1.1',
                'slug' => '1.1.1',
                'beta' => true,
                'video_link' => '',
                'image1' => 'image3.jpg',
                'image2' => 'image4.jpg',
                'image3' => 'image5.jpg',
                'image4' => null,

                'link_platform_pc' => null,
                'link_platform_mac' => null,
                'link_platform_ios' => null,
                'link_platform_android' => null,
                'link_platform_unity' => null,
                'link_platform_other' => null,

                'upcoming_features' => "Upcomming feaures 1.1.1",
                'changes' => ''
            ]
        );

        DB::table('versions')->insert($versions);
    }
}
