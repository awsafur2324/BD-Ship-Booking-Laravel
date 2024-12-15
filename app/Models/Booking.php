<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
  use HasFactory;

    // Define the table name if not using plural by default
    protected $table = 'booking';

    // Define the fillable fields
    protected $fillable = [
        'seat_tag',
        'seat_price',
        'seat_category',
        'user_id',
        'shipDetails_id',
        'departurePoints_id',
        'Seat_map_id',
    ];


    // Define relationships (optional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shipDetails()
    {
        return $this->belongsTo(ShipDetail::class);
    }

    public function departurePoints()
    {
        return $this->belongsTo(DeparturePoint::class);
    }

    public function seatMap()
    {
        return $this->belongsTo(SeatMap::class);
    }
}