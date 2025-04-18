<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'product_id';
    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'product_image',
        'categories_id',  // Changed from category_id to categories_id
        'product_price',
        'quantity_store'
    ];

    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id', 'product_id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'product_id', 'product_id');
    }

    public function bills()
    {
        return $this->belongsToMany(Bill::class, 'bill_product', 'product_id', 'bill_id');
    }
}