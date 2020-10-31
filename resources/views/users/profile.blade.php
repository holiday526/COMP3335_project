@extends('kernel_page')

@section('content')
    <div class="h3">
        User Profile
    </div>
    <user-profile user-info="{{ Auth::user() }}"></user-profile>
@endsection
