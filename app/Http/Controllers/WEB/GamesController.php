<?php

namespace App\Http\Controllers\WEB;

use App\GamePlayerInfoInit;
use App\Http\Controllers\Controller;
use App\ServerInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Game;
use Illuminate\Support\Facades\DB;

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

        $server_info_init_order_server = DB::table('server_info_inits')
            ->select('*')
            ->where('server_name', '=', 'Order Server')
            ->get();

        $server_info_init_menu_server = DB::table('server_info_inits')
            ->select('*')
            ->where('server_name', '=', 'Menu Server')
            ->get();

        $all_server_info_init = DB::table('server_info_inits')
            ->select('*')
            ->get();

        foreach ($all_server_info_init as $server_info_init) {
            $new_server_info = new ServerInfo();
            $new_server_info->game_id = $new_game->id;
            $new_server_info->server_name = $server_info_init->server_name;
            $new_server_info->server_type = $server_info_init->server_type;
            $new_server_info->server_status = $server_info_init->server_status;
            $new_server_info->server_database_load_status = $server_info_init->server_database_load_status;
            $new_server_info->server_database_load_data_list = $server_info_init->server_database_load_data_list;
            $new_server_info->server_loaded_component = $server_info_init->server_loaded_component;
            $new_server_info->server_os = $server_info_init->server_os;
            $new_server_info->server_last_patch_date = $server_info_init->server_last_patch_date;
            $new_server_info->server_current_db_patch_version_id = $server_info_init->server_current_db_patch_version_id;
            $new_server_info->save();
        }

        return redirect('/dashboard');
    }
}
