<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use harshpatel991\Commentable\Traits\Commentable;

class Discussion extends Model
{
    use Commentable;

    public static $categories = [
        '' => 'Select Category',
        'general' => 'General',
        'announcements' => 'Announcements',
        'finished-games' => 'Finished Games',
        'in-progress-games' => 'In-progress Games',
        'seeking-partners' => 'Seeking Partners'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
