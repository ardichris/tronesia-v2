<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('siswa_nis')->nullable();
            $table->char('siswa_nisn',10)->nullable();
            $table->char('siswa_nik',16)->nullable();
            $table->string('siswa_nama');
            $table->char('siswa_kelamin',1)->comment('0: laki-laki, 1: perempuan');
            $table->string('siswa_kelas');
            $table->integer('siswa_absen')->nullable();
            $table->string('siswa_alamat')->nullable();
            $table->string('siswa_tempatlahir');
            $table->date('siswa_tanggallahir');
            $table->integer('siswa_tinggi')->nullable();
            $table->integer('siswa_berat')->nullable();
            $table->string('siswa_agama')->nullable();
            $table->string('siswa_status')->nullable();
            $table->string('siswa_sekolahasal')->nullable();
            $table->string('siswa_notelp')->nullable();
            $table->string('siswa_nohandphone')->nullable();
            $table->integer('siswa_poin')->nullable();
            $table->integer('siswa_anakke')->nullable();
            $table->string('siswa_namaibu')->nullable();
            $table->date('siswa_ttlibu')->nullable();
            $table->char('siswa_nikibu',16)->nullable();
            $table->string('siswa_pekerjaanibu')->nullable();
            $table->string('siswa_namaayah')->nullable();
            $table->date('siswa_ttlayah')->nullable();
            $table->char('siswa_nikayah',16)->nullable();
            $table->string('siswa_pekerjaanayah')->nullable();
            $table->string('siswa_alamatortu')->nullable();
            $table->string('siswa_wali')->nullable();
            $table->string('siswa_pekerjaanwali')->nullable();
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
        Schema::dropIfExists('siswas');
    }
}
