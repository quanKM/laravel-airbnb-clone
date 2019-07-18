<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('listing_name')->nullable();
            $table->integer('price')->nullable();
            $table->string('home_type');
            $table->string('room_type');
            $table->integer('accommodate');
            $table->integer('bedroom_count');
            $table->integer('bathroom_count');
            $table->text('summary')->nullable();
            $table->string('address')->nullable();
            $table->boolean('has_tv')->nullable();
            $table->boolean('has_kitchen')->nullable();
            $table->boolean('has_aircon')->nullable();
            $table->boolean('has_heating')->nullable();
            $table->boolean('has_internet')->nullable();
            $table->boolean('active')->nullable();
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
        Schema::dropIfExists('rooms');
    }
}
