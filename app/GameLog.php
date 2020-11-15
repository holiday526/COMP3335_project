<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameLog extends Model
{
    //
    protected $primaryKey = 'id';

    protected $fillable = [
        'game_id', 'server_id', 'action', 'on_patch_no', 'round'
    ];
}
