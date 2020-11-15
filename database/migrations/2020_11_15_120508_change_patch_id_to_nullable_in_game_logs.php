<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePatchIdToNullableInGameLogs extends Migration
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
            $table->bigInteger('server_id')->nullable()->change();
            $table->bigInteger('on_patch_no')->nullable()->change();
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
            $table->bigInteger('server_id')->change();
            $table->bigInteger('on_patch_no')->change();
        });
    }
}
