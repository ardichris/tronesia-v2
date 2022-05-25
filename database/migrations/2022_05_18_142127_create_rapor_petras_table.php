<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaporPetrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapor_petras', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('user_id');
            $table->date('rp_tanggal');
            $table->string('rp_walikelas', 100);
            $table->string('rp_pone_score',5)->nullable();
            $table->string('rp_ptwo_score',5)->nullable();
            $table->string('rp_pthree_score',5)->nullable();
            $table->string('rp_pfour_score',5)->nullable();
            $table->string('rp_pfive_score',5)->nullable();
            $table->string('rp_physical_score',5)->nullable();
            $table->text('rp_physical_desc')->nullable();
            $table->string('rp_eone_score',5)->nullable();
            $table->string('rp_etwo_score',5)->nullable();
            $table->string('rp_ethree_score',5)->nullable();
            $table->string('rp_efour_score',5)->nullable();
            $table->string('rp_efive_score',5)->nullable();
            $table->string('rp_emotional_score',25)->nullable();
            $table->text('rp_emotional_desc')->nullable();
            $table->string('rp_talent_score',5)->nullable();
            $table->text('rp_talent_desc')->nullable();
            $table->string('rp_rone_score',5)->nullable();
            $table->string('rp_rtwo_score',5)->nullable();
            $table->string('rp_rthree_score',5)->nullable();
            $table->string('rp_rfour_score',5)->nullable();
            $table->string('rp_rfive_score',5)->nullable();
            $table->string('rp_religious_score',25)->nullable();
            $table->text('rp_religious_desc')->nullable();
            $table->string('rp_academic_score',5)->nullable();
            $table->text('rp_academic_desc')->nullable();
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswas');
            $table->foreign('periode_id')->references('id')->on('periodes');
            $table->foreign('unit_id')->references('id')->on('units');
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
        Schema::dropIfExists('rapor_petras');
    }
}
