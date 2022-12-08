<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLingkupMateriToNilaiSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai_siswas', function (Blueprint $table) {
            $table->unsignedBigInteger('lingkupmateri_id');
            //$table->foreign('lingkupmateri_id')->references('id')->on('lingkup_materis');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
}
