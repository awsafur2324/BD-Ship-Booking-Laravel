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
        Schema::create('arrival_points', function (Blueprint $table) {
            $table->id();
            $table->string('arrival_point', 50);
            $table->string('arrival_time', 50);
            $table->timestamp('arrival_date');
            $table->unsignedBigInteger('departurePoints_id');
            $table->unsignedBigInteger('shipDetails_id');

            $table->foreign('departurePoints_id')->references('id')->on('departure_points')->cascadeOnUpdate()->restrictOnDelete();

            $table->foreign('shipDetails_id')->references('id')->on('ship_details')->cascadeOnUpdate()->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arrival_points');
    }
};
