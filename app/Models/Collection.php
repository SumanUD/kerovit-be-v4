<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail_image',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

}
