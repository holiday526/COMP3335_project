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

        $new_threat_intelligence_info = ThreatIntelligenceInfo::create([
            'heading' => $request->heading,
            'description' => $request->description,
            'url' => $request->url,
            'variant' => $request->variant
        ]);

        return responseFormatter($new_threat_intelligence_info, 'store');
    }

    public function threatIntelligenceUpdate(Request $request) {
        $rules = [
            'id' => 'exists:threat_intelligence_info,id|required',
            'heading' => 'string|required',
            'description' => 'string|required',
            'url' => 'string|required',
            'variant' => ['string', 'required', new CheckVariantRule()]
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->getMessages());
        }

        ThreatIntelligenceInfo::where('id', $request->id)->update($request->all());
        $thread_intelligence_info = ThreatIntelligenceInfo::find($request->id)->first();
        return responseFormatter($thread_intelligence_info, 'update');
    }

    public function threatIntelligenceDelete(Request $request) {
        $rules = [
            'id' => ['required', 'exists:threat_intelligence_info,id']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->getMessages());
        }

        $delete_count = ThreatIntelligenceInfo::destroy($request->id);
        return responseFormatter($delete_count, 'delete');
    }
}
