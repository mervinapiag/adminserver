<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpCentre extends Model
{
    use HasFactory;

    public function site()
    {
        $this->belongsTo(SiteSetting::class);
    }
}
