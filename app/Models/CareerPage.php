<?php

// app/Models/CareerPage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerPage extends Model
{
    protected $fillable = [
        'banner_image',
        'banner_description',
        'below_banner_description',
        'below_description_image',
        'apply_link',
    ];
}
