<?php

namespace Yumb\MagicLogin\Commands;

use Illuminate\Console\Command;

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
