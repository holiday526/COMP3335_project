<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlertColumnInServerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('server_infos', function (Blueprint $table) {
            //
            $table->addColumn('integer', 'alert')->default(0)->after('server_os');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('server_infos', function (Blueprint $table) {
            //
            $table->dropColumn('alert');
        });
    }
}