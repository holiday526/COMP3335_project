<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServerTypeColumnInGameIncidenTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_incident_inits', function (Blueprint $table) {
            //
            $table->string('server_type')->after('error_server_name');
        });

        Schema::table('game_incident_handles', function (Blueprint $table) {
            $table->string('server_type')->after('error_server_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_incident_inits', function (Blueprint $table) {
            //
            $table->dropColumn('server_type');
        });

        Schema::table('game_incident_handles', function (Blueprint $table) {
            $table->dropColumn('server_type');
        });

    }
}
