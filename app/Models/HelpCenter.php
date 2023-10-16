<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'solution',
        'site_setting_id'
    ];

    public function site()
    {
        $this->belongsTo(SiteSetting::class);
    }
}
