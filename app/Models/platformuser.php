<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformUser extends Model
{
    use HasFactory;

    protected $connection ='member';
    
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'verifi_email',
        'verifi_email_verified_at',
        'id_photo_path',
        'is_verified',
        'verifi_expiration_date',
        'abonnement_expiration_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_verified'                => 'boolean',
        'verifi_email_verified_at'   => 'datetime',
        'verifi_expiration_date'     => 'date',
        'abonnement_expiration_date' => 'date',
    ];



    public function scopeActive($query)
    {
        return $query->where('abonnement_expiration_date', '>=', now()->toDateString());
    }

    public function scopeExpired($query)
    {
        return $query->where('abonnement_expiration_date', '<', now()->toDateString())
                     ->orWhereNull('abonnement_expiration_date');
    }


    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }


    public function isSubscriptionActive(): bool
    {
        return $this->abonnement_expiration_date !== null
            && $this->abonnement_expiration_date->isFuture();
    }

    public function isIdentityVerified(): bool
    {
        return $this->is_verified;
    }
}