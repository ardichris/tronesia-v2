<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('inv_code', 36);
            $table->string('inv_name', 100);
            $table->string('inv_serialnumber', 100)->nullable();
            $table->string('inv_condition', 100)->nullable();
            $table->string('inv_photo', 100)->nullable();
            $table->string('inv_location', 100)->nullable();
            $table->date('inv_date')->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

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
        Schema::dropIfExists('inventories');
    }
}
