<?php

namespace App\Enums;

enum AdminPermission: string
{
    case ManageLocations = 'can_manage_locations';
    case ManageBrands    = 'can_manage_brands';
    case ManageDiscounts = 'can_manage_discounts';
    case ManageUsers     = 'can_manage_users';
    case ManageAdmins    = 'can_manage_admins';
    case SuperAdmin      = 'is_super_admin';

    public function label(): string
    {
        return match($this) {
            self::ManageLocations => 'Manage Locations',
            self::ManageBrands    => 'Manage Brands',
            self::ManageDiscounts => 'Manage Discounts',
            self::ManageUsers     => 'Manage Users',
            self::ManageAdmins    => 'Manage Admins',
            self::SuperAdmin      => 'Super Admin (all permissions)',
        };
    }

    public static function toArray(): array
    {
        return array_map(fn($p) => [
            'id'    => $p->value,
            'label' => $p->label(),
        ], self::cases());
    }
}