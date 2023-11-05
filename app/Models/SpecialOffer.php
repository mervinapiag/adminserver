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
        'offer',
        'special_offer'
    ];

    protected $perPage = 5;
}
