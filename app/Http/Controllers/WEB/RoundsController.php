<?php

namespace App\Http\Controllers\WEB;

use App\Game;
use App\GameLog;
use App\Http\Controllers\Controller;
use App\PatchInfo;
use App\Rules\RoundActionRule;
use App\ServerInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoundsController extends Controller
{
    //
    private function createGameLog($game_id, $action, $round, $remark, $server_id = null, $on_patch_no = null) {
        return $new_game_log = GameLog::create([
            'game_id' => $game_id,
            'server_id' => $server_id,
            'action' => $action,
            'on_patch_no' => $on_patch_no,
            'round' => $round,
            'remark' => $remark
        ]);
    }

    private function getPatchVersion($patch_id) {
        return PatchInfo::find($patch_id)->patch_version;
    }

    private function switchOnOffServer($server_id) {
        $server_info = ServerInfo::find($server_id);
        if ($server_info->server_status == 'Up') {
            $server_info->server_status = 'Down';
        } else {
            $server_info->server_status = 'Up';
        }
        $server_info->save();
    }

    public function roundHandler(Request $request) {
        $game_info = Game::where('user_id', '=', Auth::id())
                    ->where('active', '=', true)
                    ->first();

        // Games more than 20 rounds, game ends
        if ($game_info->round > 19) {
            game_ends:
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
            $round_msg = 'Skipped round '.$game_info->round;
            session(['round_message'=> $round_msg]);
            $this->createGameLog($game_info->id, $request->action, $game_info->round, $round_msg);
            goto next_round;
        }

        $server_info = null;

        if (!empty($request->server_id)) {
            $server_info = ServerInfo::find($request->server_id);
        }

        // player choose to backup
        if ($request->action == 'backup') {
            $round_msg = "Round $game_info->round: Perform $server_info->server_name ($server_info->server_type) $request->action";
            session(['round_message'=>$round_msg]);
            $this->createGameLog(
                $game_info->id,
                $request->action,
                $game_info->round,
                $round_msg,
                $request->server_id,
                $request->patch_id
            );
            goto next_round;
        }

        // player choose to rollback
        if ($request->action == 'rollback') {

            $round_msg = "Round $game_info->round: Perform $server_info->server_name ($server_info->server_type) $request->action";
            session(['round_message'=>$round_msg]);
            $this->createGameLog(
                $game_info->id,
                $request->action,
                $game_info->round,
                $round_msg,
                $request->server_id,
                $request->patch_id
            );
            $server_info->server_current_db_patch_version_id = $request->patch_id;
            $server_info->save();
            goto next_round;
        }

        if ($request->action == 'planning') {

            $patch_version = $this->getPatchVersion($request->patch_id);

            $round_msg = "";

            if ($request->patch_id == $server_info->good_patch_id) {
                $round_msg = "Round $game_info->round: Planning on patch $patch_version, maybe capable at $server_info->server_name ($server_info->server_type)";
            } else {
                if (rand(0,1)) {
                    $round_msg = "Round $game_info->round: Planning on patch $patch_version, maybe not capable at $server_info->server_name ($server_info->server_type)";
                } else {
                    $round_msg = "Round $game_info->round: Planning on patch $patch_version, maybe capable at $server_info->server_name ($server_info->server_type)";
                }
            }

            session(['round_message'=> $round_msg]);
            $this->createGameLog(
                $game_info->id,
                $request->action,
                $game_info->round,
                $round_msg,
                $request->server_id,
                $request->patch_id
            );

            goto next_round;
        }

        if ($request->action == 'testing') {

            $patch_version = $this->getPatchVersion($request->patch_id);
            if ($server_info->server_type == 'Test') {
                if ($request->patch_id == $server_info->good_patch_id) {
                    // hit the good patch
                    $yes_or_not = "";
                } else {
                    // hit the bad patch, may lose game resources.
                    $yes_or_not = "not";
                }
            } elseif ($server_info->server_type == 'Production'){
                if ($request->patch_id == $server_info->good_patch_id) {
                    // hit the good patch
                    $yes_or_not = "";
                } else {
                    // hit the bad patch, may lose game resources.
                    $yes_or_not = "not";
                }
            } elseif ($server_info->server_type == 'Backup') {
                if ($request->patch_id == $server_info->good_patch_id) {
                    // hit the good patch
                    $yes_or_not = "";
                } else {
                    // hit the bad patch, may lose game resources.
                    $yes_or_not = "not";
                }
            }

            $round_msg = "Round $game_info->round: Testing on patch $patch_version, it is $yes_or_not capable at $server_info->server_name ($server_info->server_type)";

            $this->createGameLog($game_info->id, $request->action, $game_info->round, $round_msg, $request->server_id, $request->patch_id);
            session(['round_message'=> $round_msg]);
        }

        if ($request->action == 'implementation') {

            $patch_version = $this->getPatchVersion($request->patch_id);

            $yes_or_not = "";
            $lose_money = "";

            if ($server_info->server_type == 'Test') {
                if ($request->patch_id = $server_info->good_patch_id) {
                    // hit the good patch
                    $yes_or_not = "";
                    $lose_money = "";
                } else {
                    // hit the bad patch
                    $yes_or_not = "not";
                }
            } elseif ($server_info->server_type == 'Production') {
                if ($server_info->server_status == 'Down') {
                    $this->switchOnOffServer($server_info->id);
                }

                if ($request->patch_id = $server_info->good_patch_id) {
                    // hit the good patch
                    $yes_or_not = "";
                    $lose_money = "";
                } else {
                    // hit the bad patch, lose money in Production Server
                    $yes_or_not = "not";
                    $lose_money = "This make you lose money.";
                }
            } elseif ($server_info->server_type == 'Backup') {
                if ($server_info->server_status == 'Down') {
                    $this->switchOnOffServer($server_info->id);
                }

                if ($request->patch_id = $server_info->good_patch_id) {
                    // hit the good patch
                    $yes_or_not = "";
                    $lose_money = "";
                } else {
                    // hit the bad patch, lose money in Backup Server
                    $yes_or_not = "not";
                    $lose_money = "This make you lose money.";
                }
            }

            $round_msg = "Round $game_info->round: Implementing on patch $patch_version, it is $yes_or_not capable at $server_info->server_name ($server_info->server_type). $lose_money";

            $this->createGameLog($game_info->id, $request->action, $game_info->round, $round_msg, $request->server_id, $request->patch_id);
            session(['round_message' => $round_msg]);
        }

        next_round:
        $game_info->round = $game_info->round + 1;
        $game_info->save();

        return redirect('/dashboard');
    }
}
