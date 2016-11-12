<?php

namespace App;

class RecentListItem
{
    public static $FAVORITED = ' favorited ';
    public static $ROASTED = ' roasted ';
    public static $POSTED = ' posted to ';

    public $user;
    public $action;
    public $game;

    public function create(User $user, $action, Game $game) {
        $this->user = $user;
        $this->action = $action;
        $this->game = $game;
    }

    public function toString () {
        return $this->user->username . $this->action . $this->game->name;
    }
}
