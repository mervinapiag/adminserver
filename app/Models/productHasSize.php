<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productHasSize extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'product_size_id',
    ];

    protected $with = ['size'];

    public function size()
    {
        return $this->belongsTo('App\Models\ProductSize', 'product_size_id');
    }
}
