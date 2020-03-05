<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananSeragamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan_seragams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('seragam_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('seragam_id')->references('id')->on('seragams');
            $table->foreign('barang_id')->references('id')->on('barangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemesanan_seragams');
    }
}
