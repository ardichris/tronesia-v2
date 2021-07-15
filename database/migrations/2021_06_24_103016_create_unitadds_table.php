<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitaddsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
        });
        Schema::table('siswas', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
        });
        Schema::table('absensis', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
        });
        Schema::table('barangs', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
        });
        Schema::table('jurnals', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
        });
        Schema::table('kitir_siswas', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
        });
        Schema::table('lapor_sarpras', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
        });
        Schema::table('barang_masuks', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
        });
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
        });
        Schema::table('pemakaian_barangs', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
   
}
