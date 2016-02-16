<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Slynova\Commentable\Traits\Commentable;

class Discussion extends Model
{
    use Commentable;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
