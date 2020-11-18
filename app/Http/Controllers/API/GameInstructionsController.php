<?php

namespace App\Http\Controllers\API;

use App\GameInstruction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameInstructionsController extends Controller
{
    //
    public function gameInstructionIndex() {
        return responseFormatter(GameInstruction::first(), 'index');
    }

    public function gameInstructionStore(Request $request) {
        $rules = [
            'instruction' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse($validator->errors()->getMessages());
        }
        $new_game_instruction = new GameInstruction();
        $new_game_instruction->instruction = json_encode($request->instruction);
        $new_game_instruction->save();
        return responseFormatter($new_game_instruction, 'store');
    }

    public function gameInstructionUpdate(Request $request) {
        $rules = [
            'id' => 'exists:game_instructions,id|required',
            'instruction' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return errorResponse($validator->errors()->getMessages());
        }
        $game_instruction = GameInstruction::find($request->id);
        $game_instruction->instruction = json_encode($request->instruction);
        $game_instruction->save();
        return responseFormatter($game_instruction, 'store');
    }
}
