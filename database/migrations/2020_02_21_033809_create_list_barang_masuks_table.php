<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListBarangMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_barang_masuks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('barangmasuk_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('barangmasuk_id')->references('id')->on('barang_masuks');
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
        Schema::dropIfExists('list_barang_masuks');
    }
}
