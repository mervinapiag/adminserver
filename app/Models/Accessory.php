<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'category', 'brand_name', 'stock', 'image'
    ];

    public function variants()
    {
        return $this->morphMany(ProductVariant::class, 'product');
    }

    public function images()
    {
        return $this->morphMany(ProductImage::class, 'imageable');
    }
}
