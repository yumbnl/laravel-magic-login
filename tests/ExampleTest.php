<?php

use Illuminate\Console\Command;
use function Pest\Laravel\artisan;
use Yumb\MagicLogin\Commands\MagicLoginCommand;

it('can test', function () {
    artisan(MagicLoginCommand::class)->assertExitCode(Command::SUCCESS);
});
