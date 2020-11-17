<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\PatchInfo;
use App\Rules\CheckVariantRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatchInfoController extends Controller
{
    //
    public function patchInfoIndex() {
        return responseFormatter(PatchInfo::all(), 'index');
    }

    public function patchInfoStore(Request $request) {
        $rules = [
            'patch_name' => 'string|required|unique:patch_info,patch_name',
            'patch_version' => 'string|required|unique:patch_info,patch_version',
            'patch_description' => 'string|required',
            'patch_url' => 'string|required',
            'patch_variant' => ['string', 'required', new CheckVariantRule()]
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->getMessages());
        }

        $new_patch_info = PatchInfo::create([
            'patch_name' => $request->patch_name,
            'patch_version' => $request->patch_version,
            'patch_description' => $request->patch_description,
            'patch_url' => $request->patch_url,
            'patch_variant' => $request->patch_variant
        ]);

        return responseFormatter($new_patch_info, 'store');
    }

    public function patchInfoUpdate(Request $request) {
        $rules = [
            'patch_id' => 'exists:patch_info,patch_id|required',
            'patch_name' => 'string|required|unique:patch_info,patch_name',
            'patch_version' => 'string|required|unique:patch_info,patch_version',
            'patch_description' => 'string|required',
            'patch_url' => 'string|required',
            'patch_variant' => ['string', 'required', new CheckVariantRule()]
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->getMessages());
        }

        PatchInfo::where('id', $request->id)->update($request->all());

        $patch_info = PatchInfo::find($request->id)->first();

        return responseFormatter($patch_info, 'update');
    }

    public function patchInfoDelete(Request $request) {
        $rules = [
            'patch_id' => 'exists:patch_info,patch_id|required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->getMessages());
        }

        $delete_count = PatchInfo::destroy($request->id);

        return responseFormatter($delete_count, 'delete');
    }
}
