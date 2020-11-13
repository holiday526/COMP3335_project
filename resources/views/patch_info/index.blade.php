@extends('kernel_page')

@section('content')
    <h4>Patch Information</h4>
    @foreach ($all_patch_info as $info)
    <patch-info-banner
        variant="{{ $info->patch_variant }}"
        heading="{{ $info->patch_name }}"
        description="{{ $info->patch_description }}"
        url-to-doc="{{ $info->patch_url }}"
        patch-version="{{ $info->patch_version }}"
    >
    </patch-info-banner>
    @endforeach
@endsection
