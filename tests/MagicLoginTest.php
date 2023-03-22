<?php

use Illuminate\Console\Command;
use Yumb\MagicLogin\Commands\MagicLoginCommand;
use Yumb\MagicLogin\Enums\UserIdType;
use Yumb\MagicLogin\Facades\MagicLogin;

use function Pest\Laravel\artisan;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertTrue;

it('can test', function () {
    artisan(MagicLoginCommand::class)->assertExitCode(Command::SUCCESS);
});

it('can create a login token for a user with given email', function () {
    $email = fake()->email();

    $login_token = MagicLogin::getLoginToken($email);

    assertEquals($email, $login_token->user_identifier);
    assertTrue($login_token->user_id_type->isEmail());
    assertIsString($login_token->token);

});
