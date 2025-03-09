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
        Schema::create('seat_maps', function (Blueprint $table) {
            $table->id(); // Primary key with auto_increment
            $table->string('category', 50);
            $table->integer('seat_in_rows'); // Regular integer field
            $table->integer('seat_in_columns'); // Regular integer field
            $table->string('seat_tag', 50);
            $table->integer('available_seats'); // Fixed field definition
            $table->integer('seat_price'); // Fixed field definition

            // Foreign keys
            $table->unsignedBigInteger('shipDetails_id');
            $table->unsignedBigInteger('arrivalPoints_id');

            $table->foreign('shipDetails_id')
                ->references('id')
                ->on('ship_details')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('arrivalPoints_id')
                ->references('id')
                ->on('arrival_points')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_maps');
    }
};
