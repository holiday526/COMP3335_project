<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameIncidentHandle extends Model
{
    //
    protected $primaryKey = 'id';

    protected $table = 'game_incident_handles';

    protected $fillable = [
        'id', 'game_id', 'game_incident_id', 'active'
    ];
}
