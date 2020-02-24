<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bm_kode');
            $table->date('bm_tanggal');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('barang_id')->references('id')->on('barangs');
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
        Schema::dropIfExists('barang_masuks');
    }
}
