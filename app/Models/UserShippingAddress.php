<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserShippingAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_shipping_addresses';

    protected $fillable = [
        'label',
        'user_id',
        'first_name',
        'last_name',
        'street_address',
        'building_address',
        'province',
        'city_municipality',
        'barangay',
        'postal_code',
        'email',
        'phone_number',
        'region'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
