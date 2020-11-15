<?php

namespace App\Http\Controllers\WEB;

use App\Game;
use App\Http\Controllers\Controller;
use App\Rules\RoundActionRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoundsController extends Controller
{
    //
    public function roundHandler(Request $request) {
        $game_info = Game::where('user_id', '=', Auth::id())
                    ->where('active', '=', true)
                    ->first();

        if ($game_info->round > 19) {
            session(['round_message'=>'game ends']);
            $game_info->active = false;
            $game_info->save();
            return redirect('/');
        }

        $rules = [
            'action' => ['required','string', new RoundActionRule()],
            'patch_id' => 'exists:PatchInfo,patch_id',
            'server_id' => 'exists:ServerInfo,id'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return abort(403, 'Action forbidden');
        }

        if ($request->action == 'skip') {
            session(['round_message'=>'skipped round '.$game_info->round]);
            $game_info->round = $game_info->round + 1;
            $game_info->save();
        }
        
        return redirect('/dashboard');
    }
}
