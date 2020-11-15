<?php

namespace App\Http\Controllers\WEB;

use App\Game;
use App\GameLog;
use App\Http\Controllers\Controller;
use App\Rules\RoundActionRule;
use App\ServerInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoundsController extends Controller
{
    //
    private function createGameLog($game_id, $action, $round, $server_id = null, $on_patch_no = null) {
        return $new_game_log = GameLog::create([
            'game_id' => $game_id,
            'server_id' => $server_id,
            'action' => $action,
            'on_patch_no' => $on_patch_no,
            'round' => $round
        ]);
    }

    public function roundHandler(Request $request) {
        $game_info = Game::where('user_id', '=', Auth::id())
                    ->where('active', '=', true)
                    ->first();

        // Games more than 20 rounds, game ends
        if ($game_info->round > 19) {
            session(['round_message'=>"Game Ends, Please go 'History' page and check for the result"]);
            $game_info->active = false;
            $game_info->save();
            return redirect('/');
        }

        // validation rules
        $rules = [
            'action' => ['required','string', new RoundActionRule()],
            'patch_id' => 'exists:patch_info,patch_id',
            'server_id' => 'exists:server_infos,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return abort(403, 'Action forbidden');
        }

        // player choose to skip round
        if ($request->action == 'skip') {
            session(['round_message'=>'Skipped round '.$game_info->round]);
            $this->createGameLog($game_info->id, $request->action, $game_info->round);
            goto next_round;
        }

        // player choose to backup
        if ($request->action == 'backup') {
            $server_info = ServerInfo::find($request->server_id);
            session(['round_message'=>"Round $game_info->round: Perform $server_info->server_name ($server_info->server_type) $request->action"]);
            $this->createGameLog(
                $game_info->id,
                $request->action,
                $game_info->round,
                $request->server_id,
                $request->patch_id
            );
            goto next_round;
        }

        // player choose to rollback
        if ($request->action == 'rollback') {
            $server_info = ServerInfo::find($request->server_id);
            session(['round_message'=>"Round $game_info->round: Perform $server_info->server_name ($server_info->server_type) $request->action"]);
            $this->createGameLog(
                $game_info->id,
                $request->action,
                $game_info->round,
                $request->server_id,
                $request->patch_id
            );
            $server_info->server_current_db_patch_version_id = $request->patch_id;
            $server_info->save();
            goto next_round;
        }

        next_round:
        $game_info->round = $game_info->round + 1;
        $game_info->save();

        return redirect('/dashboard');
    }
}
