<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderCancel extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function customer() 
    { 
        return $this->belongsTo(Customer::class); 
    }

    public function order() 
    { 
        return $this->belongsTo(Order::class); 
    }

    public function details() 
    { 
        return $this->hasMany(OrderCancelDetail::class); 
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }
    
}
