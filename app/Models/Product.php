<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'producttype_id',
        'product_price',
        'product_pic',
    ];

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'producttype_id');
    }

    public function recommendation()
    {
        return $this->hasOne(RecommendProduct::class, 'product_id');
    }
}