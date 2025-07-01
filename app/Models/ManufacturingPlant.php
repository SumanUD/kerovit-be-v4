<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManufacturingPlant extends Model
{
    protected $fillable = [
        'about_us_page_id',
        'plant_title',
        'plant_image',
        'plant_description'
    ];

    public function aboutUsPage()
    {
        return $this->belongsTo(AboutUsPage::class);
    }
}
