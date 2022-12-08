<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLingkupMaterisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lingkup_materis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lm_title');
            $table->text('lm_description');
            $table->integer('lm_order');
            $table->integer('lm_semester');
            $table->integer('lm_grade');
            $table->unsignedBigInteger('mapel_id');
            $table->timestamps();

            $table->foreign('mapel_id')->references('id')->on('mapels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lingkup_materis');
    }
}
