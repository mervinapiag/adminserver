<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'shipping_rate',

        'mission',
        'vision',
        'about_us',

        'history_text',

        'facebook',
        'twitter',
        'instagram',
    ];
}
