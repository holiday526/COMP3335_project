@extends('kernel_page')

@section('content')
    <div class="h3">
        History
    </div>
    <history-table items="{{ App\Game::where('user_id', Auth::user()->id)->orderBy('id','desc')->get() }}"></history-table>
@endsection
