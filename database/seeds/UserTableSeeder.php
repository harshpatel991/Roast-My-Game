<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $users = array(
            ['id' => 1,
                'username'  => 'user1',
                'email'  => 'user1@gmail.com',
                'password'  => bcrypt('password1'),
                'status' => 'unconfirmed',
                'confirmation_code' => '1234567890ABCDE3',
                'points' => '300'
            ],
            ['id' => 2,
                'username'  => 'user2',
                'email'  => 'user2@gmail.com',
                'password'  => bcrypt('password2'),
                'status' => 'unconfirmed',
                'confirmation_code' => '1234567890ABCDE3',
                'points' => '100'
            ],
            ['id' => 3,
                'username'  => 'user3',
                'email'  => 'user3@gmail.com',
                'password'  => bcrypt('password3'),
                'status' => 'unconfirmed',
                'confirmation_code' => '1234567890ABCDE3',
                'points' => '0'
            ],
            ['id' => 4,
                'username'  => 'user4',
                'email'  => 'user4@gmail.com',
                'password'  => bcrypt('password4'),
                'status' => 'unconfirmed',
                'confirmation_code' => '1234567890ABCDE3',
                'points' => '0'
            ]
        );

        DB::table('users')->insert($users);
    }
}
