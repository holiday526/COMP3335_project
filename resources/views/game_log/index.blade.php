@extends('kernel_page')

@section('content')
    <h4>Game Logs</h4>
    <game-logs-table :items="{{ $game_logs }}"></game-logs-table>
@endsection
