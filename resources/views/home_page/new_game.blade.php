@extends('kernel_page')

@section('content')
    <form action="/new_game" method="post">
        @csrf
        <button type="submit" class="btn btn-primary btn-block">New Game</button>
{{--        <a href="/new_game" class="btn btn-primary btn-block">New Game</a>--}}
    </form>
@endsection
