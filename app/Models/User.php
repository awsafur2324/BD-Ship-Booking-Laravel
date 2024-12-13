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
        'city',
        'country',
        'otp',
    ];
    protected $attributes = [
        'otp' => '0',
        'image_Url' => '',
        'delete_id' => '',
        'email_verified' => '',
        'gender' => '',
        'address' => '',
        'manager_verified' => '',
        'manager_status' => 'active',
        'city' => '',
        'country' => '',
    ];

    public function shipDetails()
    {
        return $this->hasMany(ShipDetail::class);
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
