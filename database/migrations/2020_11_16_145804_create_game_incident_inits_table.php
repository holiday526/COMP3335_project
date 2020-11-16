<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameIncidentInitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_incident_inits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('round');
            $table->string('error_server_name');
            $table->integer('money_lost');
            $table->integer('reputation_lost');
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
        Schema::dropIfExists('game_incident_inits');
    }
}
