<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //------user seeder 
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('1122'),
                'phone' => '01644453394',
                'address' => '123 Test Street',
                'image_Url' => '',
                'delete_id' => '',
                'gender' => 'male',
                'email_verified' => 'true',
                'role' => 'admin',
                'manager_verified' => '',
                'manager_status' => 'ban',
                'admin_verified' => 'true',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'otp' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('1122'),
                'phone' => '01401453394',
                'address' => '123 Test Street',
                'image_Url' => '',
                'delete_id' => '',
                'gender' => 'male',
                'email_verified' => 'true',
                'role' => 'manager',
                'manager_verified' => 'true',
                'manager_status' => 'active',
                'admin_verified' => '',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'otp' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
        //-------Discount seeder
        DB::table('add_discounts')->insert([
            [
                'discount_title' => 'zero',
                'coupon_code' => 'zero',
                'startDate' => Carbon::now(),
                'finishDate' => Carbon::now()->addYears(10),
                'discount_percentage' => 0,
                'discountImg' => 'zero.jpg',
                'discount_status' => 'fixed',
                'discount_description' => 'zero discount',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('sslcommerz_accounts')->insert([
            [
                'store_id' => 'hello66a552364cdd9',
                'store_passwd' => 'hello66a552364cdd9@ssl',
                'currency' => 'BDT',
                'success_url' => 'http://127.0.0.1:8000/PaymentSuccess',
                'fail_url' => 'http://127.0.0.1:8000/PaymentFail',
                'cancel_url' => 'http://127.0.0.1:8000/PaymentCancel',
                'ipn_url' => ' http://127.0.0.1:8000/api/PaymentIPN',
                'init_url' => 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
