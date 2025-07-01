<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageSection extends Model
{
    protected $fillable = [
        'banner_videos',
        'categories_description',
        'category_faucet_image',
        'category_showers_image',
        'category_basin_image',
        'category_toilet_image',
        'category_furniture_image',
        'category_accessories_image',
        'collections_description',
        'aurum_description',
        'aurum_image',
        'klassic_description',
        'klassic_image',
        'store_banner_image',
        'store_header',
        'store_description',
        'about_banner_video',
        'about_description',
    ];

    protected $casts = [
        'banner_videos' => 'array',
    ];
}
