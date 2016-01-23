<?php

namespace App;

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
    public static $LIKE_POINTS = 10;

    //trophy 1: 0 - 75
    //trophy 2: 75 - 150
    //trophy 3: 150 - +
    public static $LEVEL_1 = 50;
    public static $LEVEL_2 = 75;
    public static $LEVEL_3 = 100;
    public static $LEVEL_4 = 150;
    public static $LEVEL_5 = 300;

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
            return 'trophy-badge-bronze';
        } else if ($this->points <= User::$LEVEL_4) {
            return 'trophy-badge-silver';
        } else {
            return 'trophy-badge-gold';
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

}
