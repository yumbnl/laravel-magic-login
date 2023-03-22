<?php

use Illuminate\Support\Carbon;
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

    $login_token = MagicLogin::getToken($email);

    assertEquals($email, $login_token->user_identifier);
    assertTrue($login_token->user_id_type->isEmail());
    assertIsString($login_token->token);
});

it('creates a login token with correct amount of characters', function () {
    $email = fake()->email();

    $login_token = MagicLogin::getToken($email);

    assertEquals(config('magic-login.token_length'), strlen($login_token->token));
});

it('validates a login token with valid token and user identification', function () {

    $login_token = MagicLogin::getToken(fake()->email());

    $verified = MagicLogin::verifyToken($login_token->user_identifier, $login_token->token);
    
    assertTrue($verified->isValid());
});

it('invalidates an expired login token', function () {

    $login_token = MagicLogin::getToken(fake()->email());

    $this->travelTo(Carbon::now()->addMinutes(60));

    $verified = MagicLogin::verifyToken($login_token->user_identifier, $login_token->token);
    
    assertTrue($verified->isExpired());
});
