<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    // public function getOrderDatetimeAttribute($value)
    // {
    //     // รับค่าเวลาดิบ (UTC) จากฐานข้อมูล แล้วแปลงเป็นเวลา Bangkok
    //     return Carbon::parse($value)->timezone(config('app.timezone'));
    // }
    protected $casts = [
        'order_datetime' => 'datetime', // <-- เพิ่มส่วนนี้เข้าไป
    ];

    public function customer() 
    { 
        return $this->belongsTo(Customer::class); 
    }

    public function shippingAddress() 
    { 
        return $this->belongsTo(ShippingAddress::class, 'shippingaddress_id'); 
    }

    public function status() 
    { 
        return $this->belongsTo(OrderStatus::class, 'order_status_id'); 
    }

    public function promotion() 
    { 
        return $this->belongsTo(Promotion::class, 'promotion_id'); 
    }

    public function details() 
    { 
        return $this->hasMany(OrderDetail::class); 
    }

    public function payment() 
    { 
        return $this->hasOne(Payment::class); 
    }

    public function cancellation() 
    { 
        return $this->hasOne(OrderCancel::class); 
    }

    // เพิ่มฟังก์ชันนี้เข้าไป
    public function confirmation()
{

    return $this->hasOneThrough(
        \App\Models\OrderConfirm::class,
        \App\Models\Payment::class,
        'order_id', // Foreign key on payments table
        'payment_id', // Foreign key on order_confirms table
        'id', // Local key on orders table
        'id' // Local key on payments table
    );
}
}

