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
        'brand_id',
        'image',
    ];

    protected $with = ['brand', 'types', 'sizes', 'colors'];

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
}
