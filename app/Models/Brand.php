<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $connection = 'discounts';

    protected $fillable = [
        'name',
        'logo_url',
        'website',
    ];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }
}