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
        'expiration_date',
    ];

    protected $casts = [
        'latitude'        => 'float',
        'longitude'       => 'float',
        'type'            => 'integer',
        'expiration_date' => 'date',
    ];

    public function info()
    {
        return $this->hasOne(LocationInfo::class);
    }
}
