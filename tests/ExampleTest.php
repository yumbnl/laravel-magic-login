<?php

use Illuminate\Console\Command;
use Yumb\MagicLogin\Commands\MagicLoginCommand;
use function Pest\Laravel\artisan;

it('can test', function () {
    artisan(MagicLoginCommand::class)->assertExitCode(Command::SUCCESS);
});
