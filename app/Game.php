<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Slynova\Commentable\Traits\Commentable;
use Illuminate\Http\Request;
use App\Http\Utils;

class Game extends Model
{
    use Commentable;

    public static $genres = [
        '' => 'Select Genre',
        'action' => 'Action',
        'action-adventure' => 'Action-Adventure',
        'idle' => 'Idle',
        'platformer' => 'Platformer',
        'puzzle' => 'Puzzle',
        'racing' => 'Racing',
        'role-playing' => 'Role-Playing',
        'roguelike' => 'Roguelike',
        'shooter' => 'Shooter',
        'simulation' => 'Simulation',
        'sports' => 'Sports',
        'strategy' => 'Strategy'
    ];

    public static $platforms = ['platform_pc', 'platform_mac', 'platform_linux', 'platform_ios', 'platform_android', 'platform_unity', 'platform_other'];
    public static $platformDropDown = //the platforms list used for searching
        [
            '' => 'Select Platform',
            'platform_pc' => 'PC',
            'platform_mac' => 'Mac',
            'platform_linux' => 'Linux',
            'platform_ios' => 'iOS',
            'platform_android' => 'Android',
            'platform_unity' => 'Unity Web',
            'platform_other' => 'Other Web'
        ];

    public static $platformColumnToIcon = [
        'link_platform_pc'       => 'icon-windows',
        'link_platform_mac'      => 'icon-apple',
        'link_platform_linux'    => 'icon-linux',
        'link_platform_unity'    => 'icon-unity',
        'link_platform_other'    => 'icon-html5',
        'link_platform_ios'      => 'icon-iphone-home',
        'link_platform_android'  => 'icon-android'
    ];

    public static $platformColumnToDownloadText= [
        'link_platform_pc'       => 'Download for PC',
        'link_platform_mac'      => 'Download for Mac',
        'link_platform_linux'    => 'Download for Linux',
        'link_platform_unity'    => 'Play with Unity Web',
        'link_platform_other'    => 'Play with Other Web',
        'link_platform_ios'      => 'Download for iOS',
        'link_platform_android'  => 'Download for Android'
    ];

    public static $linkEnumToGlyph = [
        'link_social_greenlight'       => 'icon-greenlight',
        'link_social_kickstarter'      => 'icon-kickstarter',
        'link_social_website'          => 'icon-network',
        'link_social_twitter'          => 'icon-twitter',
        'link_social_youtube'          => 'icon-youtube',
        'link_social_google_plus'      => 'icon-gplus',
        'link_social_facebook'         => 'icon-facebook'
    ];

    public static $linkEnumToText = [
        'link_social_greenlight'       => 'Steam Greenlight',
        'link_social_kickstarter'      => 'Kickstarter',
        'link_social_website'          => 'Website',
        'link_social_twitter'          => 'Twitter',
        'link_social_youtube'          => 'YouTube',
        'link_social_google_plus'      => 'Google Plus',
        'link_social_facebook'         => 'Facebook'
    ];

    public static function getBackupImageUploadPath() { return public_path().'/upload/'; }

    public static function translatePlatformLinkTo_Icon_Name_Link($platformLinks) {
        $translated = array();
        foreach($platformLinks as $columnName => $link) {
            $row = array();
            array_push($row, Game::$platformColumnToIcon[$columnName]);
            array_push($row, Game::$platformColumnToDownloadText[$columnName]);
            array_push($row, $link);

            array_push($translated, $row);
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

    public function setGameFromRequest($game, Request $request) {
        $game->title = $request->get('title');
        $game->user_id = $request->user()->id;
        $game->genre = $request->genre;

        if($request->hasFile('thumbnail')) {
            $game->thumbnail = Utils::upload_image_thumbnail($request->file('thumbnail'), $game->slug . '-thumb', $game->slug);
        }

        $game->description = $request->description;

        $game->link_social_greenlight = $request->has('link_social_greenlight') ? $request->link_social_greenlight : null;
        $game->link_social_kickstarter = $request->has('link_social_kickstarter') ? $request->link_social_kickstarter : null;
        $game->link_social_website = $request->has('link_social_website') ? $request->link_social_website : null;
        $game->link_social_twitter = $request->has('link_social_twitter') ? $request->link_social_twitter : null;
        $game->link_social_youtube = $request->has('link_social_youtube') ? $request->link_social_youtube : null;
        $game->link_social_google_plus = $request->has('link_social_google_plus') ? $request->link_social_google_plus : null;
        $game->link_social_facebook = $request->has('link_social_facebook') ? $request->link_social_facebook : null;
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
