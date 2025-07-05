<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'banner_image',
        'is_popular',
        'published_date',
        'description',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [    
        'published_date' => 'date',
        'is_popular' => 'boolean',
    ];
}
