@extends('kernel_page')

@section('content')
    @if (Session::has('round_message'))
        <script>
            alert("{{ Session::get('round_message') }}");
        </script>
        {{ Session::forget('round_message') }}
    @endif
    <form action="/new_game" method="post">
        @csrf
        <button type="submit" class="btn btn-primary btn-block">New Game</button>
    </form>
@endsection
