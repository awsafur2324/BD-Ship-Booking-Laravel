<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatMap extends Model
{
    use HasFactory;
    protected $fillable = ['category', 'amount_of_seats', 'seat_in_rows', 'amount_of_columns', 'amount_of_seats', 'seat_price', 'seat_tag', 'departurePoints_id', 'shipDetails_id'];
    public function departurePoint()
    {
        return $this->belongsTo(DeparturePoint::class);
    }
    public function shipDetail()
    {
        return $this->belongsTo(ShipDetail::class);
    }
}

