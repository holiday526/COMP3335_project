<?php

namespace App\Http\Controllers\WEB;

use App\GameIncidentHandle;
use App\GameIncidentInit;
use App\GamePlayerInfoInit;
use App\Http\Controllers\Controller;
use App\PatchInfo;
use App\ServerInfo;
use App\ServerInfoInit;
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

        $order_server_init_patch = ServerInfoInit::where('server_name', '=', 'Order Server')->first()->server_current_db_patch_version_id;
        $menu_server_init_patch = ServerInfoInit::where('server_name', '=', 'Menu Server')->first()->server_current_db_patch_version_id;

        $patch_info_id = PatchInfo::pluck('patch_id')->toArray();

        $random_good_patch_order_server = [];
        $random_good_patch_menu_server = [];

        if (($key = array_search($order_server_init_patch, $patch_info_id)) !== false) {
            $random_good_patch_order_server = $patch_info_id;
            unset($random_good_patch_order_server[$key]);
        }

        if (($key = array_search($menu_server_init_patch, $patch_info_id)) !== false) {
            $random_good_patch_menu_server = $patch_info_id;
            unset($random_good_patch_menu_server[$key]);
        }

        $random_good_patch_order_server = $random_good_patch_order_server[array_rand($random_good_patch_order_server,1)];
        $random_good_patch_menu_server = $random_good_patch_menu_server[array_rand($random_good_patch_menu_server,1)];

        foreach ($server_info_init_order_server as $server_info_init) {
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
            $new_server_info->good_patch_id = $random_good_patch_order_server;
            $new_server_info->save();
        }

        foreach ($server_info_init_menu_server as $server_info_init) {
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
            $new_server_info->good_patch_id = $random_good_patch_menu_server;
            $new_server_info->save();
        }

        // set game incident init
        $game_incident_inits = GameIncidentInit::all();
        foreach ($game_incident_inits as $game_incident_init) {
            GameIncidentHandle::create([
                'game_id' => $new_game->id,
                'active' => false,
                'server_shutdown' => $game_incident_init->server_shutdown,
                'round' => $game_incident_init->round,
                'error_server_name' => $game_incident_init->error_server_name,
                'money_lost' => $game_incident_init->money_lost,
                'reputation_lost' => $game_incident_init->reputation_lost,
                'incident_message' => $game_incident_init->incident_message,
                'server_type' => $game_incident_init->server_type
            ]);
        }

        return redirect('/dashboard');
    }

    public function gameLogIndex() {
        $player_games = Game::where('user_id', '=', Auth::id())->pluck('id')->toArray();
        $game_logs = DB::table('game_logs')
            ->select('game_id', 'remark')
            ->whereIn('game_id', $player_games)
            ->orderBy('game_id', 'desc')
            ->orderBy('round', 'asc')
            ->get();

        return view('game_log.index')->with(['game_logs'=>$game_logs]);
    }
}
