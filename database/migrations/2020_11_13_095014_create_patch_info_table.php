<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatchInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patch_info', function (Blueprint $table) {
            $table->bigIncrements('patch_id');
            $table->string('patch_name');
            $table->string('patch_version');
            $table->string('patch_description');
            $table->string('patch_url');
            $table->string('patch_variant');
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
        Schema::dropIfExists('patch_info');
    }
}
