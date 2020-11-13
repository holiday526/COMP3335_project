<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\ThreatIntelligenceInfo;
use Illuminate\Http\Request;

class ThreatIntelligencesController extends Controller
{
    //
    public function threatIntelligenceIndex() {
        $all_threat_info = ThreatIntelligenceInfo::all();
        return view('threat_intelligence.index')->with(['all_threat_info'=>$all_threat_info]);
    }
}
