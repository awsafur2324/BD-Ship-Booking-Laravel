<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeparturePoint extends Model
{
    use HasFactory;
    protected $fillable = [
        'departure_form',
        'departure_time',
        'departure_date',
        'shipDetails_id'
    ];
    public function shipDetails()
    {
        return $this->belongsTo(ShipDetail::class);
    }
}
