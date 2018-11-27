<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerialNumberActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('serial_number_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('serial_number_id')->unsigned();
            $table->string('note',255)->nullable();
            $table->enum('action', ['reserve', 'release']);
            $table->timestamps();
        });
        Schema::table('serial_number_activities', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('serial_number_id')->references('id')->on('serial_numbers');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('serial_number_activities');
        Schema::enableForeignKeyConstraints();
    }
}
