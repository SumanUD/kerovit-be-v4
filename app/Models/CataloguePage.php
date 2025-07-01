<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CataloguePage extends Model
{
    protected $fillable = ['description'];

    public function categories()
    {
        return $this->hasMany(CatalogueCategory::class);
    }
}

