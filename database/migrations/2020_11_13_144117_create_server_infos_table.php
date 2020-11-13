<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('game_id');
            $table->string('server_name');
            $table->string('server_type');
            $table->string('server_status');
            $table->string('server_database_load_status');
            $table->json('server_database_load_data_list');
            $table->json('server_loaded_component');
            $table->string('server_os');
            $table->string('server_last_patch_date');
            $table->bigInteger('server_current_db_patch_version_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_infos');
    }
}
