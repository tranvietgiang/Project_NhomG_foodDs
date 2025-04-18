<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    //

    protected $primaryKey = 'review_id'; // Khai báo khóa chính mới
    public $incrementing = true;         // ID tự tăng
    protected $keyType = 'int';

    protected $fillable = [
        'review_rating',
        'review_comment',
        'product_id',
        'user_id',
    ];


    /**
     ✅ Một sản phẩm có nhiều đánh giá.
     ✅ Một đánh giá chỉ thuộc về một sản phẩm. 
     * */
    public function products(): belongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function users(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}