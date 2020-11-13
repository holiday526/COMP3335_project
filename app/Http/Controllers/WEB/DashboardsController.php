<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\ServerInfo;
use Illuminate\Http\Request;
use App\Game;
use Illuminate\Support\Facades\Auth;

class DashboardsController extends Controller
{
    //
    public function dashboardIndex() {
        $game_info = Game::where('user_id', Auth::user()->id)->where('active', 1)->orderBy('id','desc')->first();

        // if no active game, redirect to new game page
        if (empty($game_info)) {
            return redirect('/');
        }

        $order_servers = ServerInfo::where('server_name', 'Order Server')->where('game_id', $game_info->id)->get();
        $menu_servers = ServerInfo::where('server_name', 'Menu Server')->where('game_id', $game_info->id)->get();

        //
        return view(
            'dashboard.dashboard',
            [
                'game_info'=>$game_info,
                'order_servers'=>$order_servers,
                'menu_servers'=>$menu_servers
            ]
        );
    }
}
