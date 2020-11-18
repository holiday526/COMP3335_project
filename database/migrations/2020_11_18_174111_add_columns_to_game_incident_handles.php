<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToGameIncidentHandles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_incident_handles', function (Blueprint $table) {
            //
            $table->dropColumn('game_incident_id');

            $table->float('reputation_lost')->after('active');
            $table->float('money_lost')->after('active');
            $table->string('error_server_name')->after('active');
            $table->integer('round')->after('active');
            $table->boolean('server_shutdown')->after('active');
            $table->string('incident_message')->after('server_shutdown');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_incident_handles', function (Blueprint $table) {
            //
            $table->bigInteger('game_incident_id')->after('game_id');

            $table->dropColumn('reputation_lost');
            $table->dropColumn('money_lost');
            $table->dropColumn('error_server_name');
            $table->dropColumn('round');
            $table->dropColumn('server_shutdown');
            $table->dropColumn('incident_message');

        });
    }
}
