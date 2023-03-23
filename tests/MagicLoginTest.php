<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertTrue;
use Yumb\MagicLogin\Events\TokenRequestedEvent;
use Yumb\MagicLogin\Facades\MagicLogin;

it('can create a login token for a user with given email', function () {
    $email = fake()->email();

    $login_token = MagicLogin::createToken($email);

    assertEquals($email, $login_token->user_identifier);
    assertTrue($login_token->user_id_type->isEmail());
    assertIsString($login_token->token);
});

it('creates a login token with correct amount of characters', function () {
    $email = fake()->email();

    $login_token = MagicLogin::createToken($email);

    assertEquals(config('magic-login.token_length'), strlen($login_token->token));
});

it('dispatches an event when token has been requested', function () {
    Event::fake(TokenRequestedEvent::class);

    $email = fake()->email();
    $this->post(
        route('magictoken.request'),
        ['user_identifier' => $email]
    );

    Event::assertDispatched(TokenRequestedEvent::class, function ($e) use ($email) {
        return $e->login_token->user_identifier === $email;
    });
});

it('validates a login token with valid token and user identification', function () {
    $login_token = MagicLogin::createToken(fake()->email());

    $verified = MagicLogin::verifyToken($login_token->user_identifier, $login_token->token);

    assertTrue($verified->isValid());
});

it('invalidates an expired login token', function () {
    $login_token = MagicLogin::createToken(fake()->email());

    $this->travelTo(Carbon::now()->addMinutes(60));

    $verified = MagicLogin::verifyToken($login_token->user_identifier, $login_token->token);

    assertTrue($verified->isExpired());
});
