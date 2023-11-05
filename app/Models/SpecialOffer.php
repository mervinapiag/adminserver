<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'description',
        'code',
        'shipping_off_value',
        'price_off_value',
        'type'
    ];

    protected $perPage = 5;
}
