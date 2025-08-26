<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $primaryKey = ['order_id', 'product_id'];
    public $incrementing = false;

    public function product() 
    { 
        return $this->belongsTo(Product::class); 
    }
}