<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'type', 'status', 'gender', 'brand_name', 'image'
    ];

    public function variants()
    {
        return $this->hasMany('App\Models\ProductVariant', 'shoe_id');
    }

    public function images()
    {
        return $this->morphMany(ProductImage::class, 'imageable');
    }

    public function recommended_accessories()
    {
        return $this->hasMany(Accessory::class);
    }
}
