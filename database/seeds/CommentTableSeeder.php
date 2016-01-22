<?php

use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->delete();

        $versions = array(
            ['id' => 1,
                'title' => '',
                'body' => 'This is a test comment by user 1 on game 5',

                'parent_id' => NULL,
                'lft' => 1,
                'rgt' => 2,
                'depth' => 0,

                'commentable_id' => 5,
                'commentable_type' => 'App\Game',
                'user_id' => 1,
                'username' => 'user1',

                'positive' => 'story',
                'negative' => 'level_design'
            ],
            ['id' => 2,
                'title' => '',
                'body' => 'This is a test comment by user 3 on game 3',

                'parent_id' => NULL,
                'lft' => 1,
                'rgt' => 2,
                'depth' => 0,

                'commentable_id' => 3,
                'commentable_type' => 'App\Game',
                'user_id' => 3,
                'username' => 'user3',

                'positive' => 'level_design',
                'negative' => 'animation'
            ],
            ['id' => 3,
                'title' => '',
                'body' => 'Reply to user1 by user3',

                'parent_id' => 1,
                'lft' => 2,
                'rgt' => 3,
                'depth' => 1,

                'commentable_id' => 5,
                'commentable_type' => NULL,
                'user_id' => 3,
                'username' => 'user3',

                'positive' => NULL,
                'negative' => NULL
            ],
            ['id' => 4,
                'title' => '',
                'body' => 'Comment on game 7 by user2',

                'parent_id' => NULL,
                'lft' => 4,
                'rgt' => 5,
                'depth' => 0,

                'commentable_id' => 7,
                'commentable_type' => 'App\Game',
                'user_id' => 2,
                'username' => 'user2',

                'positive' => NULL,
                'negative' => NULL
            ]
        );

        DB::table('comments')->insert($versions);
    }
}
