<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Slynova\Commentable\Traits\Commentable;


class Game extends Model
{
    use Commentable;

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
        'platform_windows_store'    => 'icon-network',
        'platform_ios'      => 'icon-apple',
        'platform_android'  => 'icon-android'
    ];

    public static $platformEnumToText = [
        'platform_pc'       => 'PC',
        'platform_mac'      => 'Mac',
        'platform_unity'    => 'Unity Web',
        'platform_windows_store'    => 'Windows Mobile',
        'platform_ios'      => 'iOS',
        'platform_android'  => 'Android'
    ];

    public static $linkEnumToGlyph = [
        'link_social_greenlight'          => 'icon-network',
        'link_social_website'          => 'icon-network',
        'link_social_twitter'          => 'icon-twitter',
        'link_social_youtube'          => 'icon-youtube',
        'link_social_google_plus'      => 'icon-gplus',
        'link_social_facebook'         => 'icon-facebook'
    ];

    public static $linkEnumToText = [
        'link_social_greenlight'          => 'Steam Greenlight',
        'link_social_website'          => 'Website',
        'link_social_twitter'          => 'Twitter',
        'link_social_youtube'          => 'YouTube',
        'link_social_google_plus'      => 'Google Plus',
        'link_social_facebook'         => 'Facebook'
    ];

    public static function getBackupImageUploadPath() { return public_path().'/upload/'; }

    public static function translatePlatformToGlyphAndText($toTranslate) {
        $translated = array();
        foreach($toTranslate as $oldkey => $platform) {
            $translated[Game::$platformEnumToGlyph[$platform]] = Game::$platformEnumToText[$platform];
        }
        return $translated;
    }

    public static function translateLinkToGlyph($toTranslate) {
        $translated = array();
        foreach($toTranslate as $oldkey => $value) {
            if($value != null) {
                $translated[$oldkey] = Game::$linkEnumToGlyph[$oldkey];
            }
        }
        return $translated;
    }

    public static function translateLinkText($toTranslate) {
        $translated = array();
        foreach($toTranslate as $oldkey => $value) {
            if($value != null) {
                $translated[$oldkey] = Game::$linkEnumToText[$oldkey];
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
