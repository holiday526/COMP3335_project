<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGameIdColumnToGameLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_logs', function (Blueprint $table) {
            //
            $table->addColumn('integer', 'game_id')->after('id');
            $table->addColumn('integer', 'round')->after('on_patch_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_logs', function (Blueprint $table) {
            //
            $table->dropColumn('game_id');
            $table->dropColumn('round');
        });
    }
}
