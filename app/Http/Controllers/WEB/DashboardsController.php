<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Game;
use Illuminate\Support\Facades\Auth;

class DashboardsController extends Controller
{
    //
    public function dashboardIndex() {
        $game_info = Game::where('user_id', Auth::user()->id)->where('active', 1)->orderBy('id','desc')->first();
        if (empty($game_info)) {
            return redirect('/');
        }
        return view('dashboard.dashboard', ['game_info'=>$game_info]);
    }
}
