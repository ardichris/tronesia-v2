<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKmrDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kmr_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kmr_id', 36);
            $table->unsignedBigInteger('mapel_id');
            $table->integer('kmr_score')->nullable();
            $table->char('kmr_predicate',1)->nullable();
            $table->text('kmr_description1')->nullable();
            $table->text('kmr_description2')->nullable();
            $table->timestamps();

            $table->foreign('kmr_id')->references('id')->on('kurmer_reports');
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
        Schema::dropIfExists('kmr_details');
    }
}
