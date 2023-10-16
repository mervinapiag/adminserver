<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'vision',
        'mission',
        'logo'
    ];

    public function help()
    {
        return $this->hasMany(HelpCenter::class);
    }
}
