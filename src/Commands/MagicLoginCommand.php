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
        $this->comment('Magic Login Token Rulez');

        return self::SUCCESS;
    }
}
