<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamePlayerInfoInitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_player_info_inits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('budget');
            $table->integer('active_user');
            $table->integer('reputation');
            $table->integer('round');
            $table->integer('manpower');
            $table->integer('manpower_inuse');
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
        Schema::dropIfExists('game_player_info_inits');
    }
}
