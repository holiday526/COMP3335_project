<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServerDownColumnToGameIncidentInits extends Migration
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
            $table->boolean('server_shutdown')->after('error_server_name')->default(true);
            $table->string('incident_message')->after('reputation_lost');
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
            $table->dropColumn('server_shutdown');
            $table->dropColumn('incident_message');
        });
    }
}
