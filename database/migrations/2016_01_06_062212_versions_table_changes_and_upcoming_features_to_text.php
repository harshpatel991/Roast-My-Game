<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VersionsTableChangesAndUpcomingFeaturesToText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `versions` MODIFY `upcoming_features` TEXT;');
        DB::statement('ALTER TABLE `versions` MODIFY `changes` TEXT;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
