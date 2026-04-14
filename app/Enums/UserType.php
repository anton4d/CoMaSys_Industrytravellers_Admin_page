<?php

namespace App\Enums;

enum UserType: int
{
    case All = 0;

    public function label(): string
    {
        return match ($this) {
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

    public static function resolve(mixed $value): self
    {
        if ($value === null || $value === '') {
            return self::All;
        }

        if (is_numeric($value)) {
            $enum = self::tryFrom((int) $value);
            if ($enum) return $enum;
            throw new \ValueError("Invalid UserType integer \"{$value}\", either change the CSV or add a new UserType case with value {$value}.");
        }

        foreach (self::cases() as $case) {
            if (strtolower($case->name) === strtolower($value)) {
                return $case;
            }
        }

        throw new \ValueError("Invalid UserType value: \"{$value}\", either change the CSV or add a new UserType case with value {$value}..");
    }
}
