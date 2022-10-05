<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    public function up()
    {
        /*Moives*/
        Schema::create('movies', function($table) {
            $table->increments('id');
            $table->string('title');
            $table->text('synopsis')->nullable();
            $table->timestamps();
        });

        /*Shows*/
        Schema::create('shows', function($table) {
            $table->increments('id');
            $table->string('show_room');
            $table->double('ticket_price', 8, 2);
            $table->dateTime('show_time');
            $table->double('duration');
            $table->boolean('booking_status')->default(false);
            $table->integer('movie_id')->unsigned();
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->timestamps();
        });

        /*Seating*/
        Schema::create('seating_types', function($table) {
            $table->increments('id');
            $table->enum('type', ['vip', 'couple', 'super_vip', 'usual']);
            $table->integer('seat_number');
            $table->timestamps();
        });

        Schema::create('bookings', function($table) {
            $table->id('id');
            $table->foreignId('show_id')->references('id')->on('shows');
            $table->timestamps();
        });

        Schema::create('seat_allocations', function($table) {
            $table->id('id');
            $table->foreignId('movie_id')->references('id')->on('movies');
            $table->foreignId('show_id')->references('id')->on('shows');
            $table->foreignId('booking_id')->references('id')->on('bookings');
            $table->double('discount');
            $table->boolean('is_allocated', 1)->default(false);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
