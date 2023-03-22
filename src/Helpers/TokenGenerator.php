<?php

namespace Yumb\MagicLogin\Helpers;

use Yumb\MagicLogin\Interfaces\TokenGeneratorInterface;

class TokenGenerator implements TokenGeneratorInterface {

    public function getToken(int $length = 5): string
    {
        return $this->generateToken($length);
    }

    private function randomChar(): string
    {
        $validChars = config('magic-login.token_characters');
        $index = mt_rand(0, strlen($validChars)-1);

        return $validChars[$index];
    }

    private function generateToken($length): string
    {
        $tokenKey = '';

        for ($i = 0; $i < $length; $i++) {
            $tokenKey .= $this->randomChar();
        }

        return $tokenKey;
    }

}