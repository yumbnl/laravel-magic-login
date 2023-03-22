<?php

namespace Yumb\MagicLogin\Commands;

use Illuminate\Console\Command;
use Yumb\MagicLogin\Models\MagicLoginToken;

class MagicLoginCommand extends Command
{
    public $signature = 'magic-login';

    public $description = 'My command';

    public function handle(): int
    {
        $login_token = MagicLoginToken::factory()->make();

        $this->comment('Token: '.$login_token->token);

        return self::SUCCESS;
    }
}
