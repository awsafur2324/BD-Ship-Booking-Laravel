<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSeat extends Model
{
    use HasFactory;

    protected $table = 'invoice_seats';
    protected $fillable = [
        'seat_tag',
        'seat_price',
        'discount_price',
        'user_id',
        'invoice_id',
        'seatMap_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function seatMap()
    {
        return $this->belongsTo(SeatMap::class);
    }

}
