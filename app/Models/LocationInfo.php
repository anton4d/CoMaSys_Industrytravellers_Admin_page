<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationInfo extends Model
{
    protected $connection = 'discounts';
    
    protected $fillable = [
        'location_id',
        'address',
        'description',
        'link',
        'photo_path',
        'discount_info',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}