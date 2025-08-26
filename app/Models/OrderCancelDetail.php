<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderCancelDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $incrementing = false;
    protected $primaryKey = ['order_cancel_id', 'product_id'];

    /**
     * บอก Laravel ว่า Model นี้ไม่มีคอลัมน์ created_at และ updated_at
     * @var bool
     */
    public $timestamps = false; // <-- เพิ่มบรรทัดนี้

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }
}
