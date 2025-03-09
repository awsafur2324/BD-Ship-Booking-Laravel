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
        Schema::create('refund_histories', function (Blueprint $table) {
            $table->id();
            $table->string('reason', 200);
            $table->string('Refund_amount')->default(0);
            $table->string('Refund_status', 50);

            $table->unsignedBigInteger('invoices_id');
            $table->foreign('invoices_id')->references('id')->on('invoices')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('shipDetails_id');
            $table->foreign('shipDetails_id')->references('id')->on('ship_details')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('departure_id');
            $table->foreign('departure_id')->references('id')->on('departure_points')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('refund_policy_id');
            $table->foreign('refund_policy_id')->references('id')->on('refund_policies')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_histories');
    }
};
