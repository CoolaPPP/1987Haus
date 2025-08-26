<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    /**
     * Primary Key ไม่ใช่ Auto-incrementing
     * @var bool
     */
    public $incrementing = false;

    /**
     * Primary Key is string
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'id',
        'promotion_name',
        'promotion_discount',
        'promotion_start',
        'promotion_end',
    ];
}