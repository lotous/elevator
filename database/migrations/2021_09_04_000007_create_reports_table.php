<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->time('current_time');
            $table->foreignId('elevator_id')->references('id')->on('elevators');
            $table->foreignId('sequence_id')->references('id')->on('sequences');
            $table->foreignId('start_floor_id')->references('id')->on('floors');
            $table->foreignId('end_floor_id')->references('id')->on('floors');
            $table->integer('floor_traveled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
