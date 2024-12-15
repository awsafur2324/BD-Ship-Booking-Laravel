<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->string('seat_tag', 50);
            $table->string('seat_price', 50);
            $table->string('seat_category', 50);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shipDetails_id');
            $table->unsignedBigInteger('departurePoints_id');
            $table->unsignedBigInteger('Seat_map_id');


            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('departurePoints_id')->references('id')->on('departure_points')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('shipDetails_id')->references('id')->on('ship_details')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('Seat_map_id')->references('id')->on('seat_maps')->cascadeOnUpdate()->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
