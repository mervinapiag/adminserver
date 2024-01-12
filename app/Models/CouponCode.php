<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'code',
        'value',
        'type',
        'times_of_use',
        'used',
        'date_start',
        'date_end',
        'is_no_time_limit',
        'once_per_customer',
        'apply_category',
        'apply_product'
    ];
}
