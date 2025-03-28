<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Categories extends Model
{
    //
    protected $primaryKey = 'categories_id'; // Khai báo khóa chính mới
    public $incrementing = true;         // ID tự tăng
    protected $keyType = 'int';          // Kiểu dữ liệu là số nguyên

    protected $fillable = [
        'categories_name',
    ];


    public function products(): hasMany
    {
        return $this->hasMany(Products::class, 'categories_id', 'categories_id');
    }
}