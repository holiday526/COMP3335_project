@extends('kernel_page')

@section('content')
    <b-container fluid>
        <div class="h3">
            Dashboard
            @if (!empty($game_info))
                <span class="float-right">Game ID: {{ $game_info->id }}</span>
            @else
                <script>
                    window.location.replace({{url('/')}});
                </script>
            @endif
        </div>
        <!-- Round card -->
        <b-row>
            <b-card class="text-center border-primary mx-3 mb-3 w-100">
                <div class="text-gray-800 text-lg">
                    Round: <span class="text-info">{{ str_pad(strval($game_info->round), 2, "0", STR_PAD_LEFT) }}</span>/20
                </div>
            </b-card>
        </b-row>
        <!-- end of Round card -->

        @if(Session::has('round_message'))
            <b-alert variant="info" show align="center">{{ Session::get('round_message') }}</b-alert>
        @endif

        <!-- Game info card -->
        <b-row>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Budget
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${{ $game_info->budget }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Manpower
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <span class="text-primary">{{ $game_info->manpower }}</span>/10
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Active Users
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $game_info->active_user }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Reputation
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <span class="text-success">{{ $game_info->reputation }}</span>/100
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-star fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </b-row>
        <!-- end of Game info card -->


        <b-row>
            @foreach($menu_servers as $menu_server)
            <b-col>
                <system-card
                    machine-name="{{ $menu_server->server_name }} ({{ $menu_server->server_type }})"
                    machine-status="{{ $menu_server->server_status }}"
                    database-load="{{ $menu_server->server_database_load_status }}"
                    current-patch="{{ App\PatchInfo::find($menu_server->server_current_db_patch_version_id)->patch_version }}"
                    machine-alert="{{ $menu_server->alert }}"
                    machine-id="{{ $menu_server->id }}"
                >
                </system-card>
            </b-col>
            @endforeach
        </b-row>
        <b-row>
            @foreach($order_servers as $order_server)
                <b-col>
                    <system-card
                        machine-name="{{ $order_server->server_name }} ({{ $order_server->server_type }})"
                        machine-status="{{ $order_server->server_status }}"
                        database-load="{{ $order_server->server_database_load_status }}"
                        current-patch="{{ App\PatchInfo::find($order_server->server_current_db_patch_version_id)->patch_version }}"
                        machine-alert="{{ $order_server->alert }}"
                        machine-id="{{ $order_server->id }}"
                    >
                    </system-card>
                </b-col>
            @endforeach
        </b-row>

        <form action="/round" method="post">
            @csrf
            <input type="hidden" name="action" value="skip">
            <b-button type="submit" variant="warning" block class="my-2">Skip Round</b-button>
        </form>
    </b-container>
@endsection
