<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipDetail extends Model
{
    use HasFactory;
    protected $table = 'ship_details';
    protected $fillable = [
        'ship_name',
        'couch_no',
        'ship_register_no',
        'ship_manager_name',
        'ship_manager_number',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function refundPolicies()
    {
        return $this->hasMany(RefundPolicy::class);
    }
    public function departurePoint()
    {
        return $this->hasMany(DeparturePoint::class);
    }
    public function arrivalPoint()
    {
        return $this->hasMany(ArrivalPoint::class);
    }
    public function seatMap()
    {
        return $this->hasMany(SeatMap::class);
    }
    // Define relationships (if needed)

}
