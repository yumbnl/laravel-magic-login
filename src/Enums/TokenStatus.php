<?php

namespace Yumb\MagicLogin\Enums;

use Yumb\MagicLogin\Exceptions\ExpiredTokenException;
use Yumb\MagicLogin\Exceptions\InvalidTokenException;
use Yumb\MagicLogin\Exceptions\InvalidUserIdException;

enum TokenStatus: string
{
    case FRESH = 'fresh';
    case VALID = 'valid';
    case INVALID = 'invalid';
    case EXPIRED = 'expired';
    case INVALID_USERID = 'invalid_userid';

    public static function FRESH(): string
    {
        return self::FRESH->value;
    }

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

    public static function INVALID_USERID(): string
    {
        return self::INVALID_USERID->value;
    }

    public function isFresh(): bool
    {
        return $this === self::FRESH;
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

    public function isInvalidUserId(): bool
    {
        return $this === self::INVALID_USERID;
    }

    public function throwError(): void
    {
        throw_if($this->isInvalid(), InvalidTokenException::class);

        throw_if($this->isExpired(), ExpiredTokenException::class);

        throw_if($this->isInvalidUserId(), InvalidUserIdException::class);
    }
}
