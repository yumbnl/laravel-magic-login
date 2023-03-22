<?php

use Illuminate\Console\Command;
use function Pest\Laravel\artisan;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertTrue;
use Yumb\MagicLogin\Commands\MagicLoginCommand;
use Yumb\MagicLogin\Facades\MagicLogin;

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

it('creates a login token with correct amount of characters', function () {
    $email = fake()->email();

    $login_token = MagicLogin::getLoginToken($email);

    assertEquals(config('magic-login.token_length'), strlen($login_token->token));
});
