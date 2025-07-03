<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Range extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'order', 'collection_id', 'category_id'
    ];

    public function collection() {
        return $this->belongsTo(Collection::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('order');
    }

}
