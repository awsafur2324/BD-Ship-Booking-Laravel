<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    
    protected $table ='invoices';

    protected $fillable = [
        'total',
        'payable',
        'cus_details',
        'tran_id',
        'val_id',
        'payment_status',
        'shipDetails_id',
        'discount_id',
        'user_id',
        'departure_id',
    ];
    public function shipDetails(){
        return $this->belongsTo(ShipDetail::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function addDiscount(){
        return $this->belongsTo(AddDiscount::class);
    }
    public function departurePoint(){
        return $this->belongsTo(DeparturePoint::class);
    }
}
