<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCarePage extends Model
{
    protected $fillable = [
        'banner_image',
        'below_banner_image',
        'service_query_email',
        'info_email',
        'call_number',
        'tollfree_number',
        'whatsapp_chat',
    ];
}
