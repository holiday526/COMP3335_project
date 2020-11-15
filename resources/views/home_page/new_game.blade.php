@extends('kernel_page')

@section('content')
{{--    @if (dd(!empty(App\Game::where('user_id','=',Auth::id())->where('active', '=', true)->get())))--}}
    @if (!empty(App\Game::where('user_id','=',Auth::id())->where('active', '=', true)->orderBy('id', 'desc')->first()))

        <a href="/dashboard" class="btn btn-block btn-secondary my-2">Return to Game</a>
    @elseif (Session::has('round_message'))
        <b-alert variant="success" show center>
            <b>{{ Session::get('round_message') }}</b>
            <hr>
            Or Hit "New Game" for next game
        </b-alert>
        {{ Session::forget('round_message') }}
    @endif
    <form action="/new_game" method="post">
        @csrf
        <button type="submit" class="btn btn-primary btn-block">New Game</button>
    </form>
@endsection
