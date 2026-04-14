<?php

namespace App\Enums;

enum LocationType: int
{
    case Airport    = 1;
    case Hotel      = 2;
    case Restaurant = 3;
    case Cafe       = 4;
    case Shop       = 5;


    public function label(): string
    {
        return match ($this) {
            self::Airport    => 'Airport',
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

    public static function resolve(mixed $value): self
    {
        if ($value === null || $value === '') {
            throw new \ValueError("LocationType is required.");
        }

        if (is_numeric($value)) {
            $enum = self::tryFrom((int) $value);
            if ($enum) return $enum;
            throw new \ValueError("Invalid LocationType integer \"{$value}\", either change the CSV or add a new LocationType case with value {$value}.");
        }

        foreach (self::cases() as $case) {
            if (strtolower($case->name) === strtolower($value)) {
                return $case;
            }
        }

        throw new \ValueError("Invalid LocationType value: \"{$value}\", either change the CSV or add a new LocationType case with value {$value}..");
    }
}
