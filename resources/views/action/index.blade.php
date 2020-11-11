@extends('kernel_page')

@section('content')
    <h4>{{ $machine_name }}</h4>
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

    <h5 class="my-2">Logs & Alert</h5>

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

@endsection
