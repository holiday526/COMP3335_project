<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActionsController extends Controller
{
    //
    public function actionPageIndex($machine_id) {
        return view('action.index')->with(['machine_id'=>$machine_id]);
    }
}
