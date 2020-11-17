<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Rules\CheckVariantRule;
use App\ThreatIntelligenceInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ThreatIntelligencesController extends Controller
{
    //
    public function threatIntelligenceIndex() {
        return responseFormatter(ThreatIntelligenceInfo::all(), 'index');
    }

    public function threatIntelligenceStore(Request $request) {
        $rules = [
            'heading' => 'string|required',
            'description' => 'string|required',
            'url' => 'string|required',
            'variant' => ['string', 'required', new CheckVariantRule()]
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->getMessages());
        }

        ThreatIntelligenceInfo::create([]);

    }
}
