<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Version;
use App\Game;

class AddGameDownloads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function ($table) {
            $table->string('link_platform_pc', 255)->nullable()->after('views');
            $table->string('link_platform_mac', 255)->nullable()->after('link_platform_pc');
            $table->string('link_platform_linux', 255)->nullable()->after('link_platform_mac');
            $table->string('link_platform_ios', 255)->nullable()->after('link_platform_linux');
            $table->string('link_platform_android', 255)->nullable()->after('link_platform_ios');
            $table->string('link_platform_unity', 255)->nullable()->after('link_platform_android');
            $table->string('link_platform_other', 255)->nullable()->after('link_platform_unity');
        });

        //Move download links from versions to games
        foreach(Game::all() as $game) {
            $latestVersion = $game->versions()->orderBy('created_at', 'desc')->first();
            $game->link_platform_pc = $latestVersion->link_platform_pc;
            $game->link_platform_mac = $latestVersion->link_platform_mac;
            $game->link_platform_linux = $latestVersion->link_platform_linux;
            $game->link_platform_ios = $latestVersion->link_platform_ios;
            $game->link_platform_android = $latestVersion->link_platform_android;
            $game->link_platform_unity = $latestVersion->link_platform_unity;
            $game->link_platform_other = $latestVersion->link_platform_other;
            $game->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function ($table) {
            $table->dropColumn('link_platform_pc');
            $table->dropColumn('link_platform_mac');
            $table->dropColumn('link_platform_linux');
            $table->dropColumn('link_platform_ios');
            $table->dropColumn('link_platform_android');
            $table->dropColumn('link_platform_unity');
            $table->dropColumn('link_platform_other');
        });
    }
}
