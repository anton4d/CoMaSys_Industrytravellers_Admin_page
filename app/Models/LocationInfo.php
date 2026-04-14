<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocationInfo extends Model
{
    protected $connection = 'discounts';

    protected $fillable = [
        'location_id',
        'city_id',
        'address',
        'description',
        'link',
        'photo_path',
        'discount_info',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}