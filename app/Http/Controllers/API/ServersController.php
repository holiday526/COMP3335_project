<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\ServerInfoInit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServersController extends Controller
{
    //
    public function serverInfoInitIndex() {
        return responseFormatter(ServerInfoInit::all(), 'index');
    }

    public function serverInfoInitStore(Request $request) {
        $rules = [
            'server_name' => ['string', 'required'],
            'server_type' => ['string', 'required'],
            'server_status' => ['string', 'required'],
            'server_database_load_status' => ['string', 'required'],
            'server_database_load_data_list' => ['required'],
            'server_loaded_component' => ['required'],
            'server_os' => ['string', 'required'],
            'server_last_patch_date' => ['string', 'required'],
            'server_current_db_patch_version_id' => ['exists:patch_info,patch_id']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->getMessages());
        }

        $new_init_server = new ServerInfoInit();
        $new_init_server->server_name = $request->server_name;
        $new_init_server->server_type = $request->server_type;
        $new_init_server->server_status = $request->server_status;
        $new_init_server->server_database_load_status = $request->server_database_load_status;
        $new_init_server->server_database_load_data_list = json_encode($request->server_database_load_data_list);
        $new_init_server->server_loaded_component = json_encode($request->server_loaded_component);
        $new_init_server->server_os = $request->server_os;
        $new_init_server->server_last_patch_date = $request->server_last_patch_date;
        $new_init_server->server_current_db_patch_version_id = $request->server_current_db_patch_version_id;
        $new_init_server->save();

        return responseFormatter($new_init_server, 'store');
    }

    public function serverInfoInitUpdate(Request $request) {
        $rules = [
            'id' => ['required', 'exists:server_info_inits,id'],
            'server_name' => ['string', 'required'],
            'server_type' => ['string', 'required'],
            'server_status' => ['string', 'required'],
            'server_database_load_status' => ['string', 'required'],
            'server_database_load_data_list' => ['required'],
            'server_loaded_component' => ['required'],
            'server_os' => ['string', 'required'],
            'server_last_patch_date' => ['string', 'required'],
            'server_current_db_patch_version_id' => ['exists:patch_info,patch_id']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->getMessages());
        }

        $init_server = ServerInfoInit::find($request->id);
        $init_server->server_name = $request->server_name;
        $init_server->server_type = $request->server_type;
        $init_server->server_status = $request->server_status;
        $init_server->server_database_load_status = $request->server_database_load_status;
        $init_server->server_database_load_data_list = json_encode($request->server_database_load_data_list);
        $init_server->server_loaded_component = json_encode($request->server_loaded_component);
        $init_server->server_os = $request->server_os;
        $init_server->server_last_patch_date = $request->server_last_patch_date;
        $init_server->server_current_db_patch_version_id = $request->server_current_db_patch_version_id;
        $init_server->save();

        return responseFormatter($init_server, 'update');
    }

    public function serverInfoInitDelete(Request $request) {
        $rules = [
            'id' => ['required', 'exists:server_info_inits,id']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->getMessages());
        }

        ServerInfoInit::destroy([$request->id]);

        return response(['id_deteled'=>$request->id], 202);
    }
}
