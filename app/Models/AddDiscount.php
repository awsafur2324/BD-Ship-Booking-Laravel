<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddDiscount extends Model
{
    use HasFactory;
    protected $table = 'add_discounts';
    protected $fillable = [
        'discount_title',
        'coupon_code',
        'startDate',
        'finishDate',
        'discount_percentage',
        'discountImg',
        'discount_status',
        'discount_description',
        'user_id'
    ];

    protected $attributes = [
        'discount_description' => '',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
