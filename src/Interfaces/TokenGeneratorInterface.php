<?php

namespace Yumb\MagicLogin\Interfaces;

interface TokenGeneratorInterface {

    public function getToken(int $length): string;

}