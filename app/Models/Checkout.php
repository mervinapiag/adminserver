<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference_number',
        'user_id',
        'region',
        'first_name',
        'last_name',
        'barangay',
        'street_bldg_name',
        'postal_code',
        'city',
        'email',
        'phone_number',
        'courier',
        'payment_method',
        'receipt_img',
        'discount_code',
        'grand_total',
        'tracking_number',
        'tracking_url',
        'estimated_delivery_date',
        'delivery_status',
        'status',
        'payment_status'
    ];

    protected $with = ['items'];

    public function items()
    {
        return $this->hasMany('App\Models\CartItem', 'checkout_id');
    }
}
