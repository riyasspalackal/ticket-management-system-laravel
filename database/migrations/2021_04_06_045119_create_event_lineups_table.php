<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventLineupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_lineups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('evt_id')->unsigned();
            $table->foreign('evt_id')->references('id')->on('event_registrations')->onDelete('cascade');
            $table->longText('lineup_desc');
            $table->dateTime('date_and_time');
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
        Schema::dropIfExists('event_lineups');
    }
}
