<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePancasilaProjectElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pancasila_project_elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pp_id');
            $table->unsignedBigInteger('pe_id');
            $table->timestamps();

            $table->foreign('pp_id')->references('id')->on('pancasila_projects');
            $table->foreign('pe_id')->references('id')->on('pancasila_elements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pancasila_project_elements');
    }
}
