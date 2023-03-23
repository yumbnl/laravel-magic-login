<?php

namespace Yumb\MagicLogin\Actions;

use Yumb\MagicLogin\Enums\UserIdType;
use Yumb\MagicLogin\Events\SendTokenEmailEvent;
use Yumb\MagicLogin\Models\MagicLoginToken;

class SendTokenAction
{
    public function __invoke(MagicLoginToken $login_token)
    {
        SendTokenEmailEvent::dispatchIf(
            $login_token->user_id_type === UserIdType::EMAIL(),
            $login_token->token,
            $login_token->user_identifier,
            $login_token->expires_at
        );
    }
}
