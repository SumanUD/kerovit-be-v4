<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $fillable = [
        'dealercode','dealername', 'address','city', 'state', 'pincode', 'phone',
        'fax', 'contactnumber', 'contactperson', 'dealertype',
        'google_link', 'date_of_updation'
    ];
}
