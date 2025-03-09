<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'image_Url',
        'delete_id',
        'gender',
        'email_verified',
        'role',
        'manager_verified',
        'manager_status',
        'admin_verified',
        'city',
        'country',
        'otp',
    ];
    protected $attributes = [
        'otp' => '0',
        'image_Url' => '',
        'delete_id' => '',
        'role' => 'user',
        'email_verified' => '',
        'gender' => '',
        'address' => '',
        'manager_verified' => '',
        'manager_status' => 'inactive',
        'admin_verified' => '',
        'city' => '',
        'country' => '',
    ];

    public function shipDetails()
    {
        return $this->hasMany(ShipDetail::class);
    }    // Define relationships (if needed)
    public function addDiscount(){
        return $this->hasMany(AddDiscount::class);
    }
    
}
