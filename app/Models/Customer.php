<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Import Authenticatable
use Illuminate\Notifications\Notifiable;
use App\Models\ShippingAddress;

class Customer extends Authenticatable //Model to Auth
{
    use HasFactory, Notifiable;

    protected $table = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'tel',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class, 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}


