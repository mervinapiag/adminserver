<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    protected $fillable = [
        'courier_name',
        'shipping_rates',
        'active'
    ];

    protected function active(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value == 1 ? 'true' : 'false',
            set: fn ($value) => $value == 'true' ? 1 : 0
        );
    }
}
