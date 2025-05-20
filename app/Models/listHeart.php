<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listHeart extends Model
{

    protected $primaryKey = "heart_id";
    protected $fillable = [
        'heart_name',
        'heart_price',
        'heart_amount',
        'product_id',
        'user_id',
        'heart_image',
    ];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}