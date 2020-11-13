<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    protected $fillable = [
        'user_id', 'active', 'budget', 'active_user', 'reputation',
        'round', 'manpower', 'manpower_inuse'
    ];
}
