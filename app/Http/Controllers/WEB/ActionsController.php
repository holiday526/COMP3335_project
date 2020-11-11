<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActionsController extends Controller
{
    //
    public function actionPageIndex($machine_name) {
        return view('action.index')->with(['machine_name'=>$machine_name]);
    }
}
