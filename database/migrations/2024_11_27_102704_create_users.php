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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 50)->unique();//email unique auto index no need to index it
            $table->string('name',50);
            $table->string('phone',20);
            $table->string('role',10);
            $table->string('address');
            $table->string('image_Url');
            $table->string('delete_id');
            $table->string('gender');
            $table->string('password', 100);
            $table->string('email_verified',10);
            $table->string('manager_verified',10);
            $table->enum('manager_status', ['active', 'inactive', 'ban','pending']);
            $table->string('admin_verified');
            $table->string('city');
            $table->string('country');
            $table->string('otp',10);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
