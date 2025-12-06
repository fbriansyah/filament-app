<?php

namespace App\Enums;

enum OrderDetailStatus: string
{
    case PENDING = 'pending';
    case INPROGRESS = 'inprogress';
    case DONE = 'done';
    case CANCELLED = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::INPROGRESS => 'In Progress',
            self::DONE => 'Done',
            self::CANCELLED => 'Cancelled',
        };
    }

    public static function getArray(): array
    {
        return [
            self::PENDING->value => self::PENDING->getLabel(),
            self::INPROGRESS->value => self::INPROGRESS->getLabel(),
            self::DONE->value => self::DONE->getLabel(),
            self::CANCELLED->value => self::CANCELLED->getLabel(),
        ];
    }
}