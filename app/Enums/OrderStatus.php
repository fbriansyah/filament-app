<?php

namespace App\Enums;

enum OrderStatus: string
{
    case SCHEDULED = 'scheduled';
    case INPROGRESS = 'inprogress';
    case RESCHEDULED = 'rescheduled';
    case CANCELLED = 'cancelled';
    case DONE = 'done';


    public function getLabel(): string
    {
        return match ($this) {
            self::SCHEDULED => 'Scheduled',
            self::INPROGRESS => 'In Progress',
            self::RESCHEDULED => 'Rescheduled',
            self::CANCELLED => 'Cancelled',
            self::DONE => 'Done',
        };
    }

    public static function getArray(): array
    {
        return [
            self::SCHEDULED->value => self::SCHEDULED->getLabel(),
            self::INPROGRESS->value => self::INPROGRESS->getLabel(),
            self::RESCHEDULED->value => self::RESCHEDULED->getLabel(),
            self::CANCELLED->value => self::CANCELLED->getLabel(),
            self::DONE->value => self::DONE->getLabel(),
        ];
    }
}