<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServerShutdownRoundsColumnOnServerInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('server_infos', function (Blueprint $table) {
            //
            $table->integer('shutdown_round')->default(0)->after('server_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('server_infos', function (Blueprint $table) {
            $table->dropColumn('shutdown_round');
        });
    }
}
