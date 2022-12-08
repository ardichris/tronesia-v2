<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranPsbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_psb', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pp_no_formulir');
            $table->string('pp_student_code');
            $table->string('pp_student_name');
            $table->integer('pp_bruto');
            $table->integer('pp_subsidi');
            $table->integer('pp_tunai');
            $table->string('pp_keterangan')->nullable();
            $table->string('pp_coa')->nullable();
            $table->integer('pp_angsuran');
            $table->integer('pp_biaya');
            $table->datetime('pp_tanggal')->nullable();
            $table->integer('pp_pembayaran')->nullable();
            $table->integer('pp_terbayar')->nullable();
            $table->integer('pp_sisa')->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('periode_id');
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('periode_id')->references('id')->on('periodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran_psb');
    }
}
