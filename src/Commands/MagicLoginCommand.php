<?php

namespace Yumb\MagicLogin\Commands;

use Illuminate\Console\Command;
use Yumb\MagicLogin\Facades\MagicLogin;

class MagicLoginCommand extends Command
{
    public $signature = 'magic-login';

    public $description = 'My command';

    public function handle(): int
    {
        // $login_token = MagicLoginToken::factory()->make();

        $login_token = MagicLogin::getToken(fake()->email());

        $this->comment('Token: '.$login_token->token);

        return self::SUCCESS;
    }
}
