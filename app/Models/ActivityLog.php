<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'page_name',
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->select(['id', 'name']);
    }
}
