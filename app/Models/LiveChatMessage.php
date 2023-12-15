<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveChatMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'live_chat_id',
        'user_id',
        'message',
    ];
}
