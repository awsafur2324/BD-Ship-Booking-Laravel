<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatMap extends Model
{
    use HasFactory;
    protected $table = 'seat_maps';
    protected $fillable = ['category', 'seat_in_rows', 'seat_in_columns', 'amount_of_seats', 'seat_price', 'seat_tag', 'shipDetails_id'];

    public function shipDetail()
    {
        return $this->belongsTo(ShipDetail::class);
    }
    // Define relationships (if needed)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
