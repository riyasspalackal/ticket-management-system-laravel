<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking-histories', function (Blueprint $table) {
             $table->increments('id');
            $table->integer('evt_id')->unsigned();
            $table->foreign('evt_id')->references('id')->on('event_registrations')->onDelete('cascade');
            $table->text('customer_name');
            $table->text('customer_email');
            $table->text('phone_number');
            $table->json('ticket_history');
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
        Schema::dropIfExists('booking-histories');
    }
}
