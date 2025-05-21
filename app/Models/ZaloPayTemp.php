<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZaloPayTemp extends Model
{
    protected $fillable = ['trans_id', 'user_id', 'data'];
}