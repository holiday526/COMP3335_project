@extends('kernel_page')

@section('content')
    <h4>{{ $machine_name }}
        @if (($machine_status = 'Up') == 'Up')
        <span class="float-right">Status: <span class="text-success">Up</span></span>
        @elseif (($machine_status = 'Busy') == 'Busy')
        <span class="float-right">Status: <span class="text-warning">Busy</span></span>
        @else
        <span class="float-right">Status: <span class="text-danger">Down</span></span>
        @endif
    </h4>

    <b-row class="h-25">
        <b-col cols="6">
            <b-card>
                <system-load-bar-chart></system-load-bar-chart>
            </b-card>
        </b-col>
        <b-col>
            <b-card no-body class="h-100">
                <b-card-header>Loaded component</b-card-header>
                <b-card-body>
                    <loaded-components-listed-group
                        :list="['Core RDBMS', 'LDAP Connector', 'SSL', 'Application Express']"
                    >
                    </loaded-components-listed-group>
                </b-card-body>
            </b-card>
        </b-col>
        <b-col>
            <b-card no-body class="h-100">
                <b-card-header>System Information</b-card-header>
                <b-card-body>
                    <system-information-stack-table
                        :system-information="[{OS: 'Oracle Linux 8.2', last_patch_date: '2020/09/21'}]"
                    >
                    </system-information-stack-table>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>

    <div class="card my-2" onclick="logCollapse()">
        <a  aria-expanded="true" style="text-decoration: none">
            <div class="card-header d-flex w-100 text-dark">
                Logs & Alert
            </div>
        </a>
        <div class="collapse" id="logsBlock">
            <div class="card-body">
                <b-row>
                    <b-col>
                        <div style="max-height: 200px; overflow-y: auto">
                            <div class="card w-100">
                                <loaded-components-listed-group
                                    :list="['2020-11-02 06:00:00 System started successfully', '2020-11-03 06:00:00 System started successfully']"
                                >
                                </loaded-components-listed-group>
                                <loaded-components-listed-group
                                    :list="['2020-11-02 06:00:00 System started successfully', '2020-11-03 06:00:00 System started successfully']"
                                >
                                </loaded-components-listed-group>
                                <loaded-components-listed-group
                                    :list="['2020-11-02 06:00:00 System started successfully', '2020-11-03 06:00:00 System started successfully']"
                                >
                                </loaded-components-listed-group>
                            </div>
                        </div>
                    </b-col>
                </b-row>
            </div>
        </div>
    </div>

    <h5>Actions</h5>
    @if ($test_server = true)
        show
    @else
        no show
    @endif
@endsection
