<?php

namespace Yumb\MagicLogin;

use Yumb\MagicLogin\Enums\TokenStatus;
use Yumb\MagicLogin\Enums\UserIdType;
use Yumb\MagicLogin\Models\MagicLoginToken;

class MagicLogin
{
    public function getToken(string $user_identifier, UserIdType|null $user_id_type = null, string $intended_url = null)
    {
        return MagicLoginToken::updateOrCreate([
            'user_identifier' => $user_identifier,
            'user_id_type' => $user_id_type ?? UserIdType::EMAIL(),
        ], [
            'intended_url' => $intended_url,
        ]);
    }

    public function verifyToken(string $user_identifier, string $token): TokenStatus
    {
        $login_token = MagicLoginToken::where('token', $token)
                                ->where('user_identifier', $user_identifier)
                                ->first();

        if (! $login_token) {
            return TokenStatus::INVALID;
        }

        if ($login_token->expires_at->isPast()) {
            return TokenStatus::EXPIRED;
        }

        return TokenStatus::VALID;
    }
}
