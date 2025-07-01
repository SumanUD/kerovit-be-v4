<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogueCategory extends Model
{
    protected $fillable = [
        'catalogue_page_id',
        'title',
        'thumbnail_image',
        'pdf_link',
    ];

    public function page()
    {
        return $this->belongsTo(CataloguePage::class);
    }
}
