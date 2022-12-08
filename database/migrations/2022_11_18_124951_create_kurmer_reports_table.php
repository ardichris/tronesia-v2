<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKurmerReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kurmer_reports', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('hrteacher_id')->nullable();
            $table->date('kmr_date')->nullable();
            $table->text('kmr_extracurricular1')->nullable();
            $table->char('kmr_extracurricular1_score',1)->nullable();
            $table->char('kmr_extracurricular1_predicate',15)->nullable();
            $table->text('kmr_extracurricular2')->nullable();
            $table->char('kmr_extracurricular2_score',1)->nullable();
            $table->char('kmr_extracurricular2_predicate',15)->nullable();
            $table->text('kmr_extracurricular3')->nullable();
            $table->char('kmr_extracurricular3_score',1)->nullable();
            $table->char('kmr_extracurricular3_predicate',15)->nullable();
            $table->integer('kmr_attedance_sick')->nullable();
            $table->integer('kmr_attedance_excuse')->nullable();
            $table->integer('kmr_attedance_alpha')->nullable();
            $table->text('kmr_note_verse')->nullable();
            $table->text('kmr_note_godword')->nullable();
            $table->text('kmr_note')->nullable();
            $table->unsignedBigInteger('creator_id');
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswas');
            $table->foreign('periode_id')->references('id')->on('periodes');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('hrteacher_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kurmer_reports');
    }
}
