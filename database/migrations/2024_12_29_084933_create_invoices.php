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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('total',50);
            $table->string('payable',50);
            $table->string('cus_details',500);
            $table->string('tran_id',100);
            $table->string('val_id',100)->default(0);
            $table->string('payment_status');

            $table->unsignedBigInteger('shipDetails_id');
            $table->foreign('shipDetails_id')->references('id')->on('ship_details')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('discount_id');
            $table->foreign('discount_id')->references('id')->on('add_discounts')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('departure_id');
            $table->foreign('departure_id')->references('id')->on('departure_points')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('invoices');
    }
};
