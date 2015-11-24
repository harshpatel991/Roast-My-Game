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
        'link-website'          => 'icon-network',
        'link-twitter'          => 'icon-twitter',
        'link-youtube'          => 'icon-youtube',
        'link-google-plus'      => 'icon-gplus',
        'link-twitch'           => 'icon-twitch',
        'link-facebook'         => 'icon-facebook',
        'link-google-play'      => 'icon-play',
        'link-app-store'        => 'icon-iphone-home',
        'link-windows-store'    => 'icon-windows',
        'link-steam'            => 'icon-steam'
    ];

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
