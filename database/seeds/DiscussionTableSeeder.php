<?php

use Illuminate\Database\Seeder;

class DiscussionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('discussion')->delete();

        $forumTopics = array(
            ['id' => 1,
                'user_id' => 1,
                'title' => 'General Discussion',
                'slug' => 'general-discussion',
                'content' => 'A place for users to discuss the site. Feature requests, bug reports, or anything else on your mind.',
                'views' => 32
            ]
        );

        DB::table('discussions')->insert($forumTopics);
    }
}
