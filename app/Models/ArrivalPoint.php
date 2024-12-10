<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrivalPoint extends Model
{
    use HasFactory;
    protected $fillable = ['arrival_point', 'arrival_time', 'arrival_date', 'departurePoints_id', 'shipDetails_id'];

    public function departurePoint()
    {
        return $this->belongsTo(DeparturePoint::class);
    }
    public function shipDetail()
    {
        return $this->belongsTo(ShipDetail::class);
    }
}
