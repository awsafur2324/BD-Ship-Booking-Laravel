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
        Schema::create('invoice_seats', function (Blueprint $table) {
            $table->id();
            $table->string('seat_tag', 50);
            $table->string('seat_price', 50);
            $table->string('discount_price', 50);

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('seatMap_id');
            $table->foreign('seatMap_id')->references('id')->on('seat_maps')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_seats');
    }
};
