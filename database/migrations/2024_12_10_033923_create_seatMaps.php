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
        Schema::create('seatMaps', function (Blueprint $table) {
            $table->id(); // Primary key with auto_increment
            $table->string('category', 50);
            $table->integer('amount_of_seats'); // Regular integer field
            $table->integer('seat_in_rows'); // Regular integer field
            $table->integer('amount_of_columns'); // Regular integer field
            $table->integer('seat_price'); // Regular integer field
            $table->string('seat_tag', 50);

            // Foreign keys
            $table->unsignedBigInteger('departurePoints_id');
            $table->unsignedBigInteger('shipDetails_id');

            $table->foreign('departurePoints_id')->references('id')->on('departurePoints')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('shipDetails_id')->references('id')->on('shipDetails')->cascadeOnUpdate()->restrictOnDelete();

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seatMaps');
    }
};
