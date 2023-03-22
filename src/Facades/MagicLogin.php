<?php

namespace Yumb\MagicLogin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Yumb\MagicLogin\MagicLogin
 */
class MagicLogin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Yumb\MagicLogin\MagicLogin::class;
    }
}
