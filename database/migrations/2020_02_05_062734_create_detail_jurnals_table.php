<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_jurnals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jurnal_id');
            $table->unsignedBigInteger('siswa_id');
            $table->string('alasan');
            $table->timestamps();

            $table->foreign('jurnal_id')->references('id')->on('jurnals');
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
        Schema::dropIfExists('detail_jurnals');
    }
}
