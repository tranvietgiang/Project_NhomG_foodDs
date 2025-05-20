<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ward extends Model
{
    //
    protected $table = 'tb_wards';
    protected $fillable = [
        'name'
    ];


    use HasFactory;

    // Mối quan hệ với District
    public function district()
    {
        return $this->belongsTo(district::class, 'district_id');
    }
}
