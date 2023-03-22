<?php

namespace Yumb\MagicLogin\Enums;

enum UserIdType: string
{
    case EMAIL = 'email';
    case SMS = 'SMS';

    public static function EMAIL(): string
    {
        return self::EMAIL->value;
    }

    public static function SMS(): string
    {
        return self::SMS->value;
    }
}
