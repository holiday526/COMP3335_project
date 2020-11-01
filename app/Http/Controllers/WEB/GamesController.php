<?php

namespace App\Http\Controllers\WEB;

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
        $old_game = Game::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first();
//        dd($old_game);
        if (!empty($old_game)) {
            $old_game->active = false;
            $old_game->save();
        }
        $new_game = Game::create([
            'user_id' => Auth::user()->id,
            'active' => true
        ]);

        return redirect('/dashboard');
//        return view('dashboard.dashboard', ['game_info'=>$new_game]);
    }
}
