<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeragamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seragams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('s_kode');
            $table->unsignedBigInteger('siswa_id');
            $table->string('s_daftarulang');
            $table->date('s_tanggal');
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seragams');
    }
}
