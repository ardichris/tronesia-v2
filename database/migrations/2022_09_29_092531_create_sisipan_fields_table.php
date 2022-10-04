<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSisipanFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sisipan_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mapel_id');
            $table->integer('jenjang');
            $table->integer('field');
            $table->unsignedBigInteger('kompetensi_id');
            $table->unsignedBigInteger('periode_id');
            $table->timestamps();

            $table->foreign('mapel_id')->references('id')->on('mapels');
            $table->foreign('periode_id')->references('id')->on('periodes');
            $table->foreign('kompetensi_id')->references('id')->on('kompetensis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sisipan_fields');
    }
}
