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
            ]
        );

        DB::table('comments')->insert($versions);
    }
}
