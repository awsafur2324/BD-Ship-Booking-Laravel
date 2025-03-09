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
        Schema::create('departure_points', function (Blueprint $table) {
            $table->id();
            $table->string('departure_point', 50);
            $table->string('departure_time', 50);
            $table->timestamp('departure_date');
            $table->string('status', 50)->default('active');
            $table->unsignedBigInteger('shipDetails_id');

            $table->foreign('shipDetails_id')->references('id')->on('ship_details')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departure_points');
    }
};
