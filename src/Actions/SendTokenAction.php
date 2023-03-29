<?php

namespace Yumb\MagicLogin\Actions;

use Illuminate\Support\Facades\Mail;
use Yumb\MagicLogin\Mail\LoginTokenMail;
use Yumb\MagicLogin\Models\MagicLoginToken;

class SendTokenAction
{
    public function __invoke(MagicLoginToken $login_token)
    {
        if ($login_token->user_id_type->isEmail()) {
            Mail::to($login_token->user_identifier)
                ->queue((new LoginTokenMail($login_token->login_link, $login_token->token))
                ->onQueue('mails'));
        }
    }
}
