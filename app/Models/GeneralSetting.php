<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'favicon',
        'header_title',
        'footer_text',
        'contact_info',
        'social_media',
        'shipping_rate',
        'about_us_image',
        'history_image',
        'about_us_text',
        'history_text',
        'privacy_policy',
        'terms_and_condition'
    ];
}
