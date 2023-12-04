<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'checkout_id',
        'product_id',
        'size',
        'session_id',
        'user_id',
        'quantity',
        'price',
        'total',
    ];
}
