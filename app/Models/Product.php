<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
        'gender',
        'socks',
        'product_category_id',
        'brand_id',
        'image',
        'stocks',
        'product_view'
    ];

    protected $with = ['category', 'brand', 'types', 'sizes', 'colors', 'reviews', 'images'];

    public function getTypesAttribute()
    {
        return $this->types()->pluck('type.name')->toArray();
    }
    
    public function category()
    {
        return $this->belongsTo('App\Models\ProductCategory', 'product_category_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\ProductBrand', 'brand_id');
    }

    public function types()
    {
        return $this->hasMany('App\Models\ProductHasType', 'product_id');
    }

    public function sizes()
    {
        return $this->hasMany('App\Models\ProductHasSize', 'product_id');
    }

    public function colors()
    {
        return $this->hasMany('App\Models\ProductHasColor', 'product_id');
    }

    public function images()
    {
        return $this->hasMany('App\Models\ProductHasImage', 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\ProductReview', 'product_id');
    }

    public function purchases()
    {
        return $this->hasMany('App\Models\CartItem', 'product_id');
    }
}
