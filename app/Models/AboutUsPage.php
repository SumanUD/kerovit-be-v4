<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsPage extends Model
{
    protected $fillable = [
        'banner_video',
        'below_banner_description',
        'director_image',
        'director_description',
        'certification_images'
    ];

    protected $casts = [
        'certification_images' => 'array',
    ];

    public function plants()
    {
        return $this->hasMany(ManufacturingPlant::class);
    }
}
