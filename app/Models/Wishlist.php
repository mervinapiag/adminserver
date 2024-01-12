<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $with = ['product'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
