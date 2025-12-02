<?php

namespace App\Enums;

enum StatusUser: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Blocked = 'blocked';
}
