<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountCoupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'discount_code',
        'total_amount',
        'is_active',
    ];
}
