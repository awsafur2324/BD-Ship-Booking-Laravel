<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundPolicy extends Model
{
    use HasFactory;
    protected $fillable = ['refund_category', 'refund_hour', 'shipDetails_id'];

    public function shipDetails()
    {
        return $this->belongsTo(ShipDetail::class);
    }
}
