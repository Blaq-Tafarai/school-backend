<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'author',
        'topic',
        'body',
        'date',
        'category',
        'image',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
