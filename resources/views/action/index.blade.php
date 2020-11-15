@extends('kernel_page')

@section('content')
    <h4>{{ App\ServerInfo::find($machine_id)->server_name }} ({{ App\ServerInfo::find($machine_id)->server_type }})
        @if (($server_status = App\ServerInfo::find($machine_id)->server_status) == 'Up')
            <span class="float-right">Status: <span class="text-success">Up</span></span>
        @elseif ($server_status == 'Busy')
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
                        system-os="{{ App\ServerInfo::find($machine_id)->server_os }}"
                        system-last-patch-date="{{ App\ServerInfo::find($machine_id)->server_last_patch_date }}"
                        system-current-db-patch-version="{{ App\PatchInfo::find(App\ServerInfo::find($machine_id)->server_current_db_patch_version_id)->patch_version }}"
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
    <!-- Backup buttons -->
    <b-row>
        <b-col>
            <form action="/round" method="POST">
                @csrf
                <input type="hidden" name="action" value="backup">
                <input type="hidden" name="patch_id" value="{{ App\ServerInfo::find($machine_id)->server_current_db_patch_version_id }}">
                <input type="hidden" name="server_id" value="{{ $machine_id }}">
                <b-button type="submit" variant="primary" id="backupButton" block>System Backup</b-button>
            </form>
        </b-col>
        <b-col>
            @if (!empty($rollback_record = App\GameLog::where('server_id', '=', $machine_id)->orderBy('id', 'desc')->first()))
                <form action="/round" method="post">
                    @csrf
                    <input type="hidden" name="action" value="rollback">
{{--                    <input type="hidden" name="patch_id" value="{{ App\GameLog::where('server_id', '=', $machine_id)->orderBy('id', 'desc')->first()->patch_id }}">--}}
                    <input type="hidden" name="patch_id" value="{{ $rollback_record->on_patch_no }}">
                    <input type="hidden" name="server_id" value="{{ $machine_id }}">
                    <b-button type="submit" variant="outline-secondary" id="rollbackButton" block>System Rollback : {{ App\PatchInfo::find($rollback_record->on_patch_no)->patch_version }}</b-button>
                </form>
            @else
                <b-button variant="outline-secondary" id="rollbackButton" class="disabled" block>System Rollback: {{ "None" }}</b-button>
            @endif
        </b-col>
    </b-row>
    <!-- end of Backup buttons -->

    <!-- Backup tooltip -->
    <b-tooltip target="backupButton">
        Perform system backup<br>cost 1 round
    </b-tooltip>
    <b-tooltip target="rollbackButton">
        Rollback to previous backup image<br>cost 1 round
    </b-tooltip>
    <!-- end of Backup tooltip -->

    <h5 class="mt-2">Patching Actions</h5>
    @if (App\ServerInfo::find($machine_id)->server_type == 'Test')
        @foreach(App\PatchInfo::where('patch_id', '!=', App\ServerInfo::find($machine_id)->server_current_db_patch_version_id)->get() as $patch)
        <b-row class="my-2">
            <b-col>
                <form action="/round" method="post">
                    @csrf
                    <input type="hidden" name="action" value="planning">
                    <input type="hidden" name="patch_id" value="{{ $patch->patch_id }}">
                    <input type="hidden" name="server_id" value="{{ $machine_id }}">
                    <b-button variant="primary" type="submit" id="{{'planning'.$patch->patch_id.'Button'}}" block>Planning &rarr; Patch: {{ $patch->patch_version }}</b-button>
                </form>
            </b-col>
            <b-col>
                <form action="/round" method="post">
                    @csrf
                    <input type="hidden" name="action" value="testing">
                    <input type="hidden" name="patch_id" value="{{ $patch->patch_id }}">
                    <input type="hidden" name="server_id" value="{{ $machine_id }}">
                    <b-button variant="secondary" type="submit" id="{{'testing'.$patch->patch_id.'Button'}}" block>Testing &rarr; Patch: {{ $patch->patch_version }}</b-button>
                </form>
            </b-col>
            <b-col>
                <form action="/round" method="post">
                    @csrf
                    <input type="hidden" name="action" value="implementation">
                    <input type="hidden" name="patch_id" value="{{ $patch->patch_id }}">
                    <input type="hidden" name="server_id" value="{{ $machine_id }}">
                    <b-button variant="success" type="submit" id="{{'implementation'.$patch->patch_id.'Button'}}" block>Implementation &rarr; Patch: {{ $patch->patch_version }}</b-button>
                </form>
            </b-col>
        </b-row>

        <b-tooltip target="{{'planning'.$patch->patch_id.'Button'}}">
            Planning on patch {{ $patch->patch_version }}<br>cost 1 round
        </b-tooltip>
        <b-tooltip target="{{'testing'.$patch->patch_id.'Button'}}">
            Testing on patch {{ $patch->patch_version }}<br>cost 1 round
        </b-tooltip>
        <b-tooltip target="{{'implementation'.$patch->patch_id.'Button'}}">
            Implementation on patch {{ $patch->patch_version }}<br>cost 1 round
        </b-tooltip>
        @endforeach
    @else
        @foreach(App\PatchInfo::where('patch_id', '!=', App\ServerInfo::find($machine_id)->server_current_db_patch_version_id)->get() as $patch)
        <b-row class="my-2">
            <b-col>
                <form action="/round" method="post">
                    @csrf
                    <input type="hidden" name="action" value="testing">
                    <input type="hidden" name="patch_id" value="{{ $patch->patch_id }}">
                    <input type="hidden" name="server_id" value="{{ $machine_id }}">
                    <b-button variant="secondary" type="submit" id="{{'testing'.$patch->patch_id.'Button'}}" block>Testing &rarr; Patch: {{ $patch->patch_version }}</b-button>
                </form>
            </b-col>
            <b-col>
                <form action="/round" method="post">
                    @csrf
                    <input type="hidden" name="action" value="implementation">
                    <input type="hidden" name="patch_id" value="{{ $patch->patch_id }}">
                    <input type="hidden" name="server_id" value="{{ $machine_id }}">
                    <b-button variant="success" type="submit" id="{{'implementation'.$patch->patch_id.'Button'}}" block>Implementation &rarr; Patch: {{ $patch->patch_version }}</b-button>
                </form>
            </b-col>
        </b-row>

        <b-tooltip target="{{'testing'.$patch->patch_id.'Button'}}">
            Testing on patch {{ $patch->patch_version }}<br>cost 1 round
        </b-tooltip>
        <b-tooltip target="{{'implementation'.$patch->patch_id.'Button'}}">
            Implementation on patch {{ $patch->patch_version }}<br>cost 1 round
        </b-tooltip>
        @endforeach
    @endif
@endsection
