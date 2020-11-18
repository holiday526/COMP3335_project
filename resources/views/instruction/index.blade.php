@extends('kernel_page')

@section('content')
    <h4>Game instruction</h4>
    <ol>
    @foreach(json_decode(App\GameInstruction::first()->instruction) as $instruct)
        <li>{{ $instruct }}</li>
    @endforeach
    </ol>
@endsection
