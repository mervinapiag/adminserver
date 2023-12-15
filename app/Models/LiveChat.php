<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveChat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference_no',
        'user_id',
        'staff_id',
    ];

    protected $with = ['messages'];

    public function messages()
    {
        return $this->hasMany('App\Models\LiveChatMessage', 'live_chat_id');
    }
}
