<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporSarprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lapor_sarpras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ls_jenis');
            $table->string('ls_sarpras');
            $table->date('ls_tanggal')->nullable();
            $table->string('ls_keterangan');
            $table->char('ls_status');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lapor_sarpras');
    }
}
