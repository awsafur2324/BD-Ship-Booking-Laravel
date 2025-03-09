<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrivalPoint extends Model
{
    use HasFactory;
    protected $table = 'arrival_points';
    protected $fillable = ['arrival_point', 'arrival_time', 'arrival_date', 'departurePoints_id', 'shipDetails_id'];

    public function seatMap()
    {
        return $this->hasMany(SeatMap::class);
    }
    public function departurePoint()
    {
        return $this->belongsTo(DeparturePoint::class);
    }
    public function shipDetail()
    {
        return $this->belongsTo(ShipDetail::class);
    }
}
