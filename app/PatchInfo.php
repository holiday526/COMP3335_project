<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatchInfo extends Model
{
    //
    protected $primaryKey = 'patch_id';

    protected $table = 'patch_info';

    protected $fillable = [
        'patch_id', 'patch_name', 'patch_version', 'patch_description', 'patch_url',
        'patch_variant'
    ];
}
