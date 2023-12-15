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

    protected $with = ['messages', 'author'];

    protected $hidden = ['messages', 'author'];

    public function messages()
    {
        return $this->hasMany('App\Models\LiveChatMessage', 'live_chat_id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->select(['id', 'name']);
    }

    public function toArray()
    {
        $this->makeVisible('messages', 'author');

        $array = parent::toArray();

        $this->makeHidden('messages', 'author');

        return $array;
    }
}
