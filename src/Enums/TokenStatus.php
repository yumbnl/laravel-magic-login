<?php

namespace Yumb\MagicLogin\Enums;

enum TokenStatus: string
{
    case VALID = 'valid';
    case INVALID = 'invalid';
    case EXPIRED = 'expired';

    public static function VALID(): string
    {
        return self::VALID->value;
    }

    public static function INVALID(): string
    {
        return self::INVALID->value;
    }

    public static function EXPIRED(): string
    {
        return self::EXPIRED->value;
    }

    public function isValid(): bool
    {
        return $this === self::VALID;
    }

    public function isInvalid(): bool
    {
        return $this === self::INVALID;
    }

    public function isExpired(): bool
    {
        return $this === self::EXPIRED;
    }
}
