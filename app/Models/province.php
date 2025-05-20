<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class province extends Model
{
    // nếu table trong database khác theo chuẩn laravel thò phải chỉ định lại tên
    protected $table = 'tb_provinces';
    protected $fillable = [
        'name'
    ];
}
