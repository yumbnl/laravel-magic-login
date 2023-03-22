<?php

namespace Yumb\MagicLogin\Commands;

use Illuminate\Console\Command;

class MagicLoginCommand extends Command
{
    public $signature = 'laravel-magic-login';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
