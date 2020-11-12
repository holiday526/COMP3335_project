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
                        :system-information="[{OS: 'Oracle Linux 8.2', last_patch_date: '2020/09/21', current_DB_patch_version: 'Version 1'}]"
                    >
                    </system-information-stack-table>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>

    <div class="card my-2" onclick="logCollapse()">
        <a aria-expanded="true" style="text-decoration: none">
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

    <h5>Backup Actions</h5>
    @if ($test_server = true)
    <b-row>
        <b-col>
            <b-button variant="primary" id="backupButton" block>System Backup</b-button>
        </b-col>
        <b-col>
            <b-button variant="outline-secondary" id="rollbackButton" block>System Rollback</b-button>
        </b-col>
    </b-row>

    <h5 class="mt-2">Patching Actions</h5>
    <b-row>
        <b-col>
            <b-button variant="primary" id="planning1Button" block>Planning &rarr; Patch: ver 1</b-button>
        </b-col>
        <b-col>
            <b-button variant="secondary" id="testing1Button" block>Testing &rarr; Patch: ver 1</b-button>
        </b-col>
        <b-col>
            <b-button variant="success" id="implementation1Button" block>Implementation &rarr; Patch: ver 1</b-button>
        </b-col>
    </b-row>
    <b-row class="mt-2">
        <b-col>
            <b-button variant="primary" id="planning2Button" block>Planning &rarr; Patch: ver 2</b-button>
        </b-col>
        <b-col>
            <b-button variant="secondary" id="testing2Button" block>Testing &rarr; Patch: ver 2</b-button>
        </b-col>
        <b-col>
            <b-button variant="success" id="implementation2Button" block>Implementation &rarr; Patch: ver 2</b-button>
        </b-col>
    </b-row>
    <b-row class="mt-2">
        <b-col>
            <b-button variant="primary" id="planning3Button" block>Planning &rarr; Patch: ver 3</b-button>
        </b-col>
        <b-col>
            <b-button variant="secondary" id="testing3Button" block>Testing &rarr; Patch: ver 3</b-button>
        </b-col>
        <b-col>
            <b-button variant="success" id="implementation3Button" block>Implementation &rarr; Patch: ver 3</b-button>
        </b-col>
    </b-row>

    @else
    <b-row>
        <b-col>
            <b-button variant="primary" id="backupButton" block>System Backup</b-button>
        </b-col>
        <b-col>
            <b-button variant="outline-secondary" id="rollbackButton" block>System Rollback</b-button>
        </b-col>
    </b-row>
    <h5 class="mt-2">Patching Actions</h5>
    <b-row>
        <b-col>
            <b-button variant="secondary" id="testing1Button" block>Testing &rarr; Patch: ver 1</b-button>
        </b-col>
        <b-col>
            <b-button variant="success" id="implementation1Button" block>Implementation &rarr; Patch: ver 1</b-button>
        </b-col>
    </b-row>
    <b-row class="mt-2">
        <b-col>
            <b-button variant="secondary" id="testing2Button" block>Testing &rarr; Patch: ver 2</b-button>
        </b-col>
        <b-col>
            <b-button variant="success" id="implementation2Button" block>Implementation &rarr; Patch: ver 2</b-button>
        </b-col>
    </b-row>
    <b-row class="mt-2">
        <b-col>
            <b-button variant="secondary" id="testing3Button" block>Testing &rarr; Patch: ver 3</b-button>
        </b-col>
        <b-col>
            <b-button variant="success" id="implementation3Button" block>Implementation &rarr; Patch: ver 3</b-button>
        </b-col>
    </b-row>
    @endif
    <b-tooltip target="backupButton">
        Perform system backup<br>cost 1 round
    </b-tooltip>
    <b-tooltip target="rollbackButton">
        Rollback to previous backup image<br>cost 1 round
    </b-tooltip>
    <b-tooltip target="planning1Button">
        Planning on patching version 1<br>cost 1 round
    </b-tooltip>
    <b-tooltip target="testing1Button">
        Testing on patching version 1<br>cost 1 round
    </b-tooltip>
    <b-tooltip target="implementation1Button">
        Implementation on patching version 1<br>cost 1 round
    </b-tooltip>
    <b-tooltip target="planning2Button">
        Planning on patching version 2<br>cost 1 round
    </b-tooltip>
    <b-tooltip target="testing2Button">
        Testing on patching version 2<br>cost 1 round
    </b-tooltip>
    <b-tooltip target="implementation2Button">
        Implementation on patching version 2<br>cost 1 round
    </b-tooltip>
    <b-tooltip target="planning3Button">
        Planning on patching version 3<br>cost 1 round
    </b-tooltip>
    <b-tooltip target="testing2Button">
        Testing on patching version 3<br>cost 1 round
    </b-tooltip>
    <b-tooltip target="implementation2Button">
        Implementation on patching version 3<br>cost 1 round
    </b-tooltip>
@endsection
