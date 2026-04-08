<?php

namespace App\Enums;

enum LocationType: int
{   
    case City       = 0;
    case Airport    = 1;
    case Hotel      = 2;
    case Restaurant = 3;
    case Cafe       = 4;
    case Shop       = 5;
    

    public function label(): string
    {
        return match($this) {
            self::City      => 'City',
            self::Airport    =>'Airport',
            self::Restaurant => 'Restaurant',
            self::Cafe       => 'Cafe',
            self::Shop       => 'Shop',
            self::Hotel      => 'Hotel',
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