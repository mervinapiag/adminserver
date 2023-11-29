<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productHasColor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'product_color_id',
    ];

    protected $with = ['color'];

    public function color()
    {
        return $this->belongsTo('App\Models\ProductColor', 'product_color_id');
    }
}
