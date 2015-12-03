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

    public static $platforms = ['platform_pc', 'platform_mac', 'platform_ios', 'platform_android', 'platform_unity', 'platform_windows_store'];

    public static $platformEnumToGlyph = [
        'platform_pc'       => 'icon-windows',
        'platform_mac'      => 'icon-apple',
        'platform_unity'    => 'icon-unity',
        'platform_windows_store'    => 'icon-windows',
        'platform_ios'      => 'icon-apple',
        'platform_android'  => 'icon-android'
    ];

    public static $linkEnumToGlyph = [
        'link_social_website'          => 'icon-network',
        'link_social_twitter'          => 'icon-twitter',
        'link_social_youtube'          => 'icon-youtube',
        'link_social_google_plus'      => 'icon-gplus',
        'link_social_facebook'         => 'icon-facebook'
    ];

    public static function getBackupImageUploadPath() { return public_path().'/upload/'; }

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

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
