<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePancasilaProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pancasila_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('pp_theme');
            $table->text('pp_name');
            $table->text('pp_desc')->nullable();
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('updater_id');
            $table->timestamps();

            $table->foreign('periode_id')->references('id')->on('periodes');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('kelas_id')->references('id')->on('kelas');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('updater_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pancasila_projects');
    }
}
