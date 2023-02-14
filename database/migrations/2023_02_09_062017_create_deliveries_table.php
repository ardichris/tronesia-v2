<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('siswa_id');
            $table->date('dlv_date');
            $table->string('dlv_item', 100);
            $table->string('dlv_sender', 50)->nullable();
            $table->integer('dlv_counter');
            $table->string('dlv_status', 25);
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswas');
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
        Schema::dropIfExists('deliveries');
    }
}
