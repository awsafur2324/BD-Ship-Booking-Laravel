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
        Schema::create('add_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('discount_title');
            $table->string('coupon_code');
            $table->datetime('startDate');
            $table->datetime('finishDate');
            $table->integer('discount_percentage');
            $table->string('discountImg');
            $table->enum('discount_status', ['active', 'inactive' , 'fixed']);
            $table->string('discount_description');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_discounts');
    }
};
