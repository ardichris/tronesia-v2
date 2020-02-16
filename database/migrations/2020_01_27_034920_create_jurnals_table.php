<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jm_kode');
            $table->unsignedBigInteger('mapel_id');
            $table->date('jm_tanggal');
            $table->string('jm_jampel');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('kompetensi_id');
            $table->string('jm_materi');
            $table->timestamps();

            $table->foreign('mapel_id')->references('id')->on('mapels');
            $table->foreign('kelas_id')->references('id')->on('kelas');
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
        Schema::dropIfExists('jurnals');
    }
}
