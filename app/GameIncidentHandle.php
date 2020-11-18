<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameIncidentHandle extends Model
{
    //
    protected $primaryKey = 'id';

    protected $table = 'game_incident_handles';

    protected $fillable = [
        'id', 'game_id', 'active', 'server_shutdown', 'round',
        'error_server_name', 'money_lost', 'reputation_lost', 'incident_message', 'server_type'
    ];
}
