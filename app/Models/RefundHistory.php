<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundHistory extends Model
{
    use HasFactory;
    protected $table = 'refund_histories';

    // Define fillable properties
    protected $fillable = [
        'reason',
        'Refund_amount',
        'Refund_status',
        'invoices_id',
        'shipDetails_id',
        'departure_id',
        'user_id',
        'refund_policy_id',
    ];

    // Define the relationships with other models

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function shipDetail()
    {
        return $this->belongsTo(ShipDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function refundPolicy()
    {
        return $this->belongsTo(RefundPolicy::class);
    }

    public function departurePoint()
    {
        return $this->hasMany(DeparturePoint::class);
    }
}
