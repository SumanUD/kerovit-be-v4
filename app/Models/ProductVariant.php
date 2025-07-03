<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
