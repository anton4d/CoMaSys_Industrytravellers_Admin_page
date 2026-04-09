<?php

namespace App\Enums;

enum UserType: int
{
    case All = 0;

    public function label(): string
    {
        return match($this) {
            self::All => 'All',
        };
    }

    public static function toArray(): array
    {
        return array_map(fn($type) => [
            'id'   => $type->value,
            'name' => $type->label(),
        ], self::cases());
    }
}