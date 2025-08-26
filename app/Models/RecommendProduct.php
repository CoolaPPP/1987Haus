<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendProduct extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'recommend_note'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
