<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = 'admin';

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'can_manage_locations',
        'can_manage_brands',
        'can_manage_discounts',
        'can_manage_users',
        'can_manage_admins',
        'is_super_admin',
    ];

    protected $casts = [
        'password'             => 'hashed',
        'can_manage_locations' => 'boolean',
        'can_manage_brands'    => 'boolean',
        'can_manage_discounts' => 'boolean',
        'can_manage_users'     => 'boolean',
        'can_manage_admins'    => 'boolean',
        'is_super_admin'       => 'boolean',
    ];

    protected $hidden = [
        'password',
    ];

}
