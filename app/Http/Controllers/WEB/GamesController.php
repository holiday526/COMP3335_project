<?php

namespace App\Http\Controllers\WEB;

use App\GamePlayerInfoInit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Game;

class GamesController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }

    public function newGameIndex() {
        return view('home_page.new_game');
    }

    public function newGameStore() {
        // search if there is any previous game
        $old_game = Game::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first();

        // if there is previous game, disable it
        if (!empty($old_game)) {
            $old_game->active = false;
            $old_game->save();
        }

        // get game info init
        $game_info_init = GamePlayerInfoInit::first();

        // create a new game
        $new_game = Game::create([
            'user_id' => Auth::user()->id,
            'active' => true,
            'budget' => $game_info_init->budget,
            'active_user' => $game_info_init->active_user,
            'reputation' => $game_info_init->reputation,
            'round' => $game_info_init->round,
            'manpower' => $game_info_init->manpower,
            'manpower_inuse' => $game_info_init->manpower_inuse
        ]);

        return redirect('/dashboard');
    }
}
