<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public static $genres = [
        '' => 'Select Genre',
        'action' => 'Action',
        'action-adventure' => 'Action-Adventure',
        'idle' => 'Idle',
        'puzzle' => 'Puzzle',
        'role-playing' => 'Role-Playing',
        'shooter' => 'Shooter',
        'simulation' => 'Simulation',
        'sports' => 'Sports',
        'strategy' => 'Strategy'
    ];

    public static $platforms = ['platform-pc', 'platform-mac', 'platform-ios', 'platform-android', 'platform-unity', 'platform-html5'];

    public static $platformEnumToGlyph = [
        'platform-pc'       => 'icon-windows',
        'platform-mac'      => 'icon-apple',
        'platform-unity'    => 'icon-unity',
        'platform-html5'    => 'icon-html5',
        'platform-ios'      => 'icon-apple',
        'platform-android'  => 'icon-android'
    ];

    public static $linkEnumToGlyph = [
        'link_website'          => 'icon-network',
        'link_twitter'          => 'icon-twitter',
        'link_youtube'          => 'icon-youtube',
        'link_google_plus'      => 'icon-gplus',
        'link_twitch'           => 'icon-twitch',
        'link_facebook'         => 'icon-facebook',
        'link_google_play'      => 'icon-play',
        'link_app_store'        => 'icon-iphone-home',
        'link_windows_store'    => 'icon-windows',
        'link_steam'            => 'icon-steam'
    ];

    public static $backupImageUploadPath = '/upload/';

    public static function translatePlatformToGlyph(&$value,$key) {
        $value = Game::$platformEnumToGlyph[$value];
    }

    public static function translateLinkToGlyph($toTranslate) {
        $translated = array();
        foreach($toTranslate as $oldkey => $value) {
            if($value != null) {
                $translated[Game::$linkEnumToGlyph[$oldkey]] = $value;
            }
        }
        return $translated;
    }

    public function versions()
    {
        return $this->hasMany('App\Version');
    }

}
