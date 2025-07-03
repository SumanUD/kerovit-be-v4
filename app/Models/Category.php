<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'collection_id',
        'name',
        'slug',
        'description',
        'thumbnail_image',
    ];

    public function collection() {
        return $this->belongsTo(Collection::class);
    }

    public function ranges()
    {
        return $this->hasMany(\App\Models\Range::class);
    }

}
