<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_id',
        'payment_pic',
        'payment_datetime',
    ];

    public function order() 
    { 
        return $this->belongsTo(Order::class); 
    }
    
    public function customer() 
    { 
        return $this->belongsTo(Customer::class); 
    }

    public function confirmation()
    {
        return $this->hasOne(OrderConfirm::class);
    }
}