<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\PatchInfo;
use Illuminate\Http\Request;

class PatchInfoController extends Controller
{
    //
    public function patchInfoIndex() {
        $all_patch_info = PatchInfo::all();
        return view('patch_info.index')->with(['all_patch_info'=>$all_patch_info]);
    }
}
