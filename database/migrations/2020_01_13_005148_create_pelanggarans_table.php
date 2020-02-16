<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelanggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggarans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pelanggaran_kode')->unique();
            $table->unsignedBigInteger('siswa_id');
            $table->date('pelanggaran_tanggal');
            $table->string('pelanggaran_jenis');
            $table->string('pelanggaran_keterangan');  
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
        Schema::dropIfExists('pelanggarans');
    }
}
