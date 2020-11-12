<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThreatIntelligencesController extends Controller
{
    //
    public function threatIntelligenceIndex() {
        return view('threat_intelligence.index');
    }
}
