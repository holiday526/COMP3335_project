@extends('kernel_page')

@section('content')
    <div class="container-fluid">
        <div class="h3">
            Dashboard
            @if (!empty($game_info = App\Game::where('user_id', Auth::user()->id)->where('active', 1)->orderBy('id','desc')->first()))
            <span class="float-right">Game ID: {{ $game_info->id }}</span>
            @else
{{--                {{ redirect('/') }}--}}
                <script>
                    window.location.replace({{url('/')}});
                </script>
            @endif
        </div>
        <b-row>
            <b-card class="text-center border-primary mx-3 mb-3 w-100">
                <div class="text-gray-800">
                    Round: {{ "##" }}/20
                </div>
            </b-card>
        </b-row>

        <b-row>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Budget
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${{ 80000 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Manpower
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <span class="text-primary">{{ 10 }}</span>/10
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Active Users
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ 500 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Reputation
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <span class="text-success">{{ 100 }}</span>/100
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </b-row>

        <b-row>
            <b-col>
                <system-card></system-card>
            </b-col>
            <b-col>
                <system-card></system-card>
            </b-col>
            <b-col>
                <system-card></system-card>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <system-card></system-card>
            </b-col>
            <b-col>
                <system-card></system-card>
            </b-col>
            <b-col>
                <system-card></system-card>
            </b-col>
        </b-row>
    </div>
@endsection
