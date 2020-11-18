<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'API\UserController@login');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');

    Route::get('/server/init', 'API\ServersController@serverInfoInitIndex');
    Route::post('/server/init', 'API\ServersController@serverInfoInitStore');
    Route::put('/server/init', 'API\ServersController@serverInfoInitUpdate');
    Route::delete('/server/init', 'API\ServersController@serverInfoInitDelete');

    Route::get('/patch', 'API\PatchInfoController@patchInfoIndex');
    Route::put('/patch', 'API\PatchInfoController@patchInfoUpdate');

    Route::get('/threat', 'API\ThreatIntelligencesController@threatIntelligenceIndex');
    Route::put('/threat', 'API\ThreatIntelligencesController@threatIntelligenceUpdate');

    Route::get('/game/instruction', 'API\GameInstructionsController@gameInstructionIndex');
    Route::put('/game/instruction', 'API\GameInstructionsController@gameInstructionUpdate');
    Route::post('/game/instruction', 'API\GameInstructionsController@gameInstructionStore');
});
