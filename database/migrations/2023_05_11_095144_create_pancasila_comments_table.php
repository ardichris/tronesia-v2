<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePancasilaCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pancasila_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pp_id');
            $table->unsignedBigInteger('siswa_id');
            $table->text('pc_comment');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('updater_id');
            $table->timestamps();

            $table->foreign('pp_id')->references('id')->on('pancasila_projects');
            $table->foreign('siswa_id')->references('id')->on('siswas');
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
        Schema::dropIfExists('pancasila_comments');
    }
}
