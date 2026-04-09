<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $connection = 'discounts';

    protected $fillable = [
        'brand_id',
        'title',
        'description',
        'expiration_date',
        'user_type',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'user_type'       => 'integer',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}