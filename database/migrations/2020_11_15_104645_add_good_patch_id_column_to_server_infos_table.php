<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoodPatchIdColumnToServerInfosTable extends Migration
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
            $table->addColumn('integer', 'good_patch_id')->after('server_current_db_patch_version_id')->default(4);
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
            $table->dropColumn('good_patch_id');
        });
    }
}
