<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstructionsController extends Controller
{
    //
    public function instructionIndex() {
        return view('instruction.index');
    }
}
