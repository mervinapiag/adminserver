<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FAQAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faq_answers';

    protected $fillable = [
        'faq_id',
        'answer_text'
    ];
}
