<?php

namespace App\Enums;

enum Status: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Blocked = 'blocked';

    public function getLabel(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
            self::Blocked => 'Blocked',
        };
    }

    public static function getArray(): array
    {
        return [
            self::Active->value => self::Active->getLabel(),
            self::Inactive->value => self::Inactive->getLabel(),
            self::Blocked->value => self::Blocked->getLabel(),
        ];
    }
}
