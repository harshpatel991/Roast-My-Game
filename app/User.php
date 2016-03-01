<?php

namespace App;

use Utils;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    public static $ADD_GAME_POINTS = 100;
    public static $ADD_VERSION_POINTS = 75;
    public static $CONFIRM_EMAIL_POINTS = 50;
    public static $COMMENT_POINTS = 25;
    public static $LIKE_POINTS = 5;

    //trophy 1: 0 - 75
    //trophy 2: 75 - 350
    //trophy 3: 350 - +
    public static $LEVEL_1 = 50;
    public static $LEVEL_2 = 75;
    public static $LEVEL_3 = 150;
    public static $LEVEL_4 = 350;
    public static $LEVEL_5 = 650;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password', 'status', 'confirmation_code'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function games()
    {
        return $this->hasMany('App\Game');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function getRank() {
        return User::where('points', '>=', $this->points)->count();
    }

    public function getLevel()
    {
        if ($this->points <= User::$LEVEL_1) {
            return 1;
        } else if ($this->points <= User::$LEVEL_2) {
            return 2;
        } else if ($this->points <= User::$LEVEL_3) {
            return 3;
        } else if ($this->points <= User::$LEVEL_4) {
            return 4;
        } else if ($this->points <= User::$LEVEL_5) {
            return 5;
        } else { //LEVEL_6
            return 6;
        }
    }

    public function addPointsAndSave($points) {
        $this->points += $points;
        $this->save();
    }

    public function getBadge()
    {
        if ($this->points <= User::$LEVEL_2) {
            return '';
        } else if ($this->points <= User::$LEVEL_4) {
            return '<span class="icon-circle trophy-badge-silver"></span>';
        } else {
            return '<span class="icon-circle trophy-badge-gold"></span>';
        }
    }

    public function getTrophyImage()
    {
        if ($this->points <= User::$LEVEL_2) {
            return 'trophy1.jpg';
        } else if ($this->points <= User::$LEVEL_4) {
            return 'trophy2.jpg';
        } else {
            return 'trophy3.jpg';
        }
    }

    public function getProfileColor() {
        $colors = ["#fe813a", "#369ff4", "#9064bf", "#fa575d", "#1abc9c"];
        return $colors[crc32($this->username)%count($colors)];
    }

    public function getProfileLetter() {
        return substr($this->username, 0, 1);
    }

    //$size needs to be the same as the size specified by the width and line-height in the $addionalClasses
    public function getProfileImage($size, $additionalClasses) {
        if ($this->profile_image == null || $this->profile_image == '') {
            return '<div class="user-default-icon ' . $additionalClasses. '" style="background-color:'.$this->getProfileColor().'; display: table;">'.
                '<div style="display: table-cell; vertical-align: middle;">'.
                    $this->getProfileLetter().
                '</div>'.
            '</div>';
        }
        return '<img width="'. $size .'" class="media-object" src="'. Utils::get_image_url('profile-images/'.$this->profile_image) .'">';
    }
}
