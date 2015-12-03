<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(GameTableSeeder::class);
        $this->call(VersionTableSeeder::class);
        $this->call(UserTableSeeder::class);
//        $this->call(LikesTableSeeder::class);

        Model::reguard();
    }
}
