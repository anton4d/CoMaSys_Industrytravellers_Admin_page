<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $connection = 'discounts';

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
    ];

    public function locationInfos(): HasMany
    {
        return $this->hasMany(LocationInfo::class);
    }

    public function needsCoordinates(): bool
    {
        return $this->latitude === 0.0 && $this->longitude === 0.0;
    }
}