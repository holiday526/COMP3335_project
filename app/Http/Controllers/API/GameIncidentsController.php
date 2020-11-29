<?php

namespace App\Http\Controllers\API;

use App\GameIncidentHandle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Game;
use Illuminate\Support\Facades\Session;

class GameIncidentsController extends Controller
{
    //
    public function BackdoorGameIncidentTurnOff() {
        $current_game_id = Game::where('user_id', Auth::id())->where('active', true)->first()->id;
        $current_game_incidents = GameIncidentHandle::where('game_id', $current_game_id)->get();
        foreach ($current_game_incidents as $current_game_incident) {
            $current_game_incident->active = false;
            $current_game_incident->round = 0;
            $current_game_incident->save();
        }
        $return = app('App\Http\Controllers\WEB\RoundsController')->backdoorFunction();

        return response(['response'=>'incident turned off '.$return], 200);
    }
}
