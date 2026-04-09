<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $connection = 'discounts';

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'type',
        'brand_id',
    ];

    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
        'type'      => 'integer',
    ];

    public function info()
    {
        return $this->hasOne(LocationInfo::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}