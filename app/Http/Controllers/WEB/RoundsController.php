<?php

namespace App\Http\Controllers\WEB;

use App\Game;
use App\GameIncidentHandle;
use App\GameLog;
use App\Http\Controllers\Controller;
use App\PatchInfo;
use App\Rules\RoundActionRule;
use App\ServerInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RoundsController extends Controller
{
    const BACKUP_HEAD_COUNT = 2;
    const ROLLBACK_HEAD_COUNT = 2;
    const PLANNING_HEAD_COUNT = 2;
    const TESTING_HEAD_COUNT = 4;
    const IMPLEMENTATION_HEAD_COUNT = 4;

    const ROLLBACK_ROUND = 1;

    const ROUND_MONEY_LOSS = -1000;
    const ROUND_USER_LOSS = -20;
    const ROUND_REPUTATION_LOSS = -5;

    const ROUND_MONEY_GAIN = 2000;
    const ROUND_USER_GAIN = 40;
    const ROUND_REPUTATION_GAIN = 10;

    private function setMoney($game_id, $gain_or_lose, $weighting) {
        $game_info = Game::find($game_id);
        $game_info->budget = $game_info->budget + $gain_or_lose * $weighting;
        $game_info->save();
    }

    private function setActiveUser($game_id, $gain_or_lose, $weighting) {
        $game_info = Game::find($game_id);
        $game_info->active_user = $game_info->active_user + $gain_or_lose *  $weighting;
        if ($game_info->active_user <= 0) {
            $game_info->active_user = 0;
        }
        $game_info->save();
    }

    private function setReputation($game_id, $gain_or_lose, $weighting) {
        $game_info = Game::find($game_id);
        $game_info->reputation = $game_info->reputation + $gain_or_lose * $weighting;
        $game_info->save();
    }

    private function getAllServerIds($game_id, $server_type = []) {
        if (empty($server_type)) {
            return ServerInfo::where('game_id', '=', $game_id)->pluck('id')->toArray();
        }
        return ServerInfo::where('game_id', '=', $game_id)->whereIn('server_type', $server_type)->pluck('id')->toArray();
    }

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

    private function switchOffServer($server_id) {
        $server_info = ServerInfo::find($server_id);
        $server_info->server_status = 'Down';
        $server_info->save();
    }

    private function serverRestore($game_id) {
        $servers = ServerInfo::where('game_id', '=', $game_id)->pluck('id')->toArray();
        foreach ($servers as $server_id) {
            $server_info = ServerInfo::find($server_id);
            if ($server_info->shutdown_round > 0) {
                $server_info->shutdown_round = $server_info->shutdown_round - 1;
//                $server_info->server_status = 'Down';
            } else {
                $server_info->server_status = 'Up';
            }
            $server_info->save();
        }
    }

    private function serverShutdownForRounds($server_id, $shutdown_round) {
        $server_info = ServerInfo::find($server_id);
        $server_info->shutdown_round = $shutdown_round;
        $server_info->server_status = 'Down';
        $server_info->server_database_load_status = 'None';
        $server_info->save();
    }

    private function usingManpower($game_id, $head_count) {
        $game_info = Game::find($game_id);
        $game_info->manpower = $game_info->manpower - $head_count;
        $game_info->manpower_inuse = $head_count;
        $game_info->save();
    }

    private function restoreManpower($game_id) {
        $game_info = Game::find($game_id);
        $game_info->manpower = $game_info->manpower + $game_info->manpower_inuse;
        $game_info->manpower_inuse = 0;
        $game_info->save();
    }

    private function checkHitGoodPatch($server_id) {
        $server = ServerInfo::find($server_id);
        return $server->server_current_db_patch_version_id == $server->good_patch_id;
    }

    // by round function
    private function checkProductionAndBackupHitGoodPatch($game_id) {
        $all_production_backup_server_id = $this->getAllServerIds($game_id, ['Production', 'Backup']);
        foreach($all_production_backup_server_id as $server_id) {
            $server_status = ServerInfo::find($server_id)->server_status;
            if (!($this->checkHitGoodPatch($server_id)) && $server_status == 'Up') {
                // lose small amount of money and reputation, also lose active users
                $this->setMoney($game_id, self::ROUND_MONEY_LOSS, rand(rand(0,1),1));
                $this->setActiveUser($game_id, self::ROUND_USER_LOSS, rand(rand(0,1), 1));
                $this->setReputation($game_id, self::ROUND_REPUTATION_LOSS, rand(rand(0,1),1));
            } elseif ($this->checkHitGoodPatch($server_id) && $server_status == 'Down') {
                // lose big amount of money and reputation, also lose active users
                $this->setMoney($game_id, self::ROUND_MONEY_LOSS, rand(rand(0,1),2));
                $this->setActiveUser($game_id, self::ROUND_USER_LOSS, rand(rand(0,1),2));
                $this->setReputation($game_id, self::ROUND_REPUTATION_LOSS, rand(rand(0,1),2));
            } else {
                // gain money and reputation, also gain active users
                $this->setMoney($game_id, self::ROUND_MONEY_GAIN, rand(rand(0,1),2));
                $this->setActiveUser($game_id, self::ROUND_USER_GAIN, rand(rand(0,1),2));
                $this->setReputation($game_id, self::ROUND_REPUTATION_GAIN, rand(rand(0,1),2));
            }
        }
    }

    // by incident function
    private function activateIncident($game_id, $current_round) {
        $all_incidents_in_game = GameIncidentHandle::where('game_id', $game_id)->get();
        foreach($all_incidents_in_game as $incident) {
            if ($incident->round == $current_round) {
                $incident->active = true;
                $incident->save();
            }
        }
    }

    // TODO: handle incidents, for example -> 1. server sudden down, 2. being hacked, 3. under DDOS attack
    private function executeIncident($game_id) {
        $activeIncidents = GameIncidentHandle::where('game_id', $game_id)->get();
        if (!empty($activeIncidents)) {
            foreach ($activeIncidents as $activeIncident) {
                // get back the specific server
                $server_info = ServerInfo::where('game_id', $game_id)
                    ->where('server_name', $activeIncident->error_server_name)
                    ->where('server_type', $activeIncident->server_type)
                    ->first();
                if ($server_info->server_current_db_patch_version_id != $server_info->good_patch_id) {
                    // execute punishment
                    // TODO: execute different punishment
                    if ($activeIncident->active == true) {
                        session(['incident_message'=>"Incident Report: $server_info->server_name ($server_info->server_type): $activeIncident->incident_message"]);
                        if ($activeIncident->server_shutdown) {
                            $this->serverShutdownForRounds($server_info->id, rand(1,2));
                        }
                    }
                } else {
                    // unset punishment
                    $activeIncident->active = false;
                    $activeIncident->save();
                    Session::forget('incident_message');
                }
            }
        }
    }

    public function roundHandler(Request $request) {
        $game_info = Game::where('user_id', '=', Auth::id())
                    ->where('active', '=', true)
                    ->first();

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

        // Games more than 20 rounds, game ends
        if ($game_info->round > 20) {
            game_ends:
            session(['round_message'=>"Game Ends, Please go 'History' page and check for the result"]);
            $game_info->active = false;
            $game_info->save();
            return redirect('/');
        }

        // each turn restore manpower & server
        $this->restoreManpower($game_info->id);
        $this->serverRestore($game_info->id);

        // player choose to skip round
        if ($request->action == 'skip') {
            $round_msg = 'Skipped round '.$game_info->round;
            session(['round_message'=> $round_msg]);
            $this->createGameLog($game_info->id, $request->action, $game_info->round, $round_msg);
            goto next_round;
        }

        $server_info = null;

        // set $server_info
        if (!empty($request->server_id)) {
            $server_info = ServerInfo::find($request->server_id);
        }

        // player choose to backup, no down time
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

            $this->usingManpower($game_info->id, self::BACKUP_HEAD_COUNT);

            goto next_round;
        }

        // player choose to rollback, have down time
        if ($request->action == 'rollback') {
            $server_info->server_current_db_patch_version_id = $request->patch_id;
            $server_info->save();

            $round_msg = "Round $game_info->round: Perform $server_info->server_name ($server_info->server_type) $request->action";
            session(['round_message'=>$round_msg]);

            $this->createGameLog($game_info->id, $request->action, $game_info->round, $round_msg, $request->server_id, $request->patch_id);

            // use manpower & have down time
            $this->usingManpower($game_info->id, self::ROLLBACK_HEAD_COUNT);
            $this->serverShutdownForRounds($server_info->id, self::ROLLBACK_ROUND);

            goto next_round;
        }

        if ($request->action == 'planning') {

            $patch_version = $this->getPatchVersion($request->patch_id);

            $round_msg = "";

            // only for testing servers, add some random to the game
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
            $this->createGameLog($game_info->id, $request->action, $game_info->round, $round_msg, $request->server_id, $request->patch_id);

            // use manpower
            $this->usingManpower($game_info->id, self::PLANNING_HEAD_COUNT);

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
            } elseif ($server_info->server_type == 'Production') {
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

            // use manpower only
            $this->usingManpower($game_info->id, self::TESTING_HEAD_COUNT);

            goto next_round;
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

            // server real implement, server will be shutdown
            // have down time
            $server_shutdown_round = rand(1,3);
            $server_shutdown_msg = "Server shutdown for $server_shutdown_round round.";

            $this->serverShutdownForRounds($server_info->id, $server_shutdown_round);

            // implementing
            $server_info->server_current_db_patch_version_id = $request->patch_id;
            $server_info->save();

            // handle round messages
            $round_msg = "Round $game_info->round: Implementing on patch $patch_version, it is $yes_or_not capable at $server_info->server_name ($server_info->server_type). $lose_money $server_shutdown_msg";
            $this->createGameLog($game_info->id, $request->action, $game_info->round, $round_msg, $request->server_id, $request->patch_id);
            session(['round_message' => $round_msg]);

            $this->usingManpower($game_info->id, self::IMPLEMENTATION_HEAD_COUNT);
            goto next_round;
        }

        next_round:
        $this->checkProductionAndBackupHitGoodPatch($game_info->id);
        $game_info->round = $game_info->round + 1;
        $game_info->save();
        $this->activateIncident($game_info->id, $game_info->round);
        $this->executeIncident($game_info->id);

        return redirect('/dashboard');
    }
}
