<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatchInfoController extends Controller
{
    //
    public function patchInfoIndex() {
        return view('patch_info.index');
    }
}
