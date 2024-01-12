<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FAQ extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faqs';

    protected $fillable = [
        'question_text',
    ];

    protected $with = ['answers'];

    public function answers()
    {
        return $this->hasMany('App\Models\FAQAnswer', 'faq_id');
    }
}
