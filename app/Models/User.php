<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use App\Models\Client;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Favorite;  // Đảm bảo có import này
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone', // Thêm phone vào fillable vì nó có trong bảng users
        'last_activity',
        'provider',
        'provider_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** format d-m-y */
    public function format_date()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y');
    }


    /** relationship with table client */
    /** mỗi user có một thông tin client */
    public function client(): HasOne
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    /** mỗi user có nhiều đánh giá */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    /** mỗi user có nhiều đơn hàng trong giỏ hàng */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function heart(): HasMany
    {
        return $this->hasMany(listHeart::class, 'user_id');
    }


    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }
}