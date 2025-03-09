<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeparturePoint extends Model
{
    use HasFactory;
    protected $table = 'departure_points';
    protected $fillable = [
        'departure_point',
        'departure_time',
        'departure_date',
        'status',
        'shipDetails_id'
    ];

    public function shipDetails()
    {
        return $this->belongsTo(ShipDetail::class);
    }
    // Define relationships (if needed)

}
