<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class discount extends Model
{
    //

    protected $fillable = [
        'discount_name',
        'discount_price',
    ];
}
