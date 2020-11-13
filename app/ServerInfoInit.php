<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServerInfoInit extends Model
{
    //
    protected $primaryKey = 'id';

    protected $table = 'server_info_inits';

    protected $fillable = [
        'server_name', 'server_type', 'server_status', 'server_database_load_status', 'server_database_load_data_list',
        'server_loaded_component', 'server_os', 'server_last_patch_date', 'server_current_db_patch_version_id'
    ];
}
