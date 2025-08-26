<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderConfirm extends Model
{
    use HasFactory;
    protected $fillable = ['payment_id', 'customer_id', 'orderconfirmed_status', 'orderconfirm_datetime'];
    public function payment() 
    { 
        return $this->belongsTo(Payment::class); 
    }

    public function customer() 
    { 
        return $this->belongsTo(Customer::class); 
    }
}