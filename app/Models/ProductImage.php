<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'imageable_id', 'imageable_type', 'image_path'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}
