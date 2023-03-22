<?php

namespace Yumb\MagicLogin;

use Yumb\MagicLogin\Enums\UserIdType;
use Yumb\MagicLogin\Models\MagicLoginToken;

class MagicLogin
{
    public function getLoginToken(string $user_identifier, UserIdType|null $user_id_type = null, string $intended_url = null)
    {
        return MagicLoginToken::updateOrCreate([
            'user_identifier' => $user_identifier,
            'user_id_type' => $user_id_type ?? UserIdType::EMAIL()
        ], [
            'intended_url' => $intended_url,
        ]);
    }
}
