<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'category_id',
        'range_id',
        'product_code',
        'product_picture',
        'product_title',
        'series',
        'shape',
        'spray',
        'product_description',
        'product_color_code',
        'product_feature',
        'product_installation_service_parts',
        'design_files',
        'additional_information',
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function range()
    {
        return $this->belongsTo(Range::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
