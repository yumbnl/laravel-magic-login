<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Yumb\MagicLogin\Events\TokenRequestedEvent;
use Yumb\MagicLogin\Exceptions\ExpiredTokenException;
use Yumb\MagicLogin\Facades\MagicLogin;
use Yumb\MagicLogin\Tests\TestModels\User;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertTrue;

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
    $this->withoutExceptionHandling();

    Event::fake([TokenRequestedEvent::class]);

    $email = fake()->email();
    $this->post(route('magictoken.request'), ['email' => $email]);

    Event::assertDispatched(TokenRequestedEvent::class, function ($e) use ($email) {
        return $e->login_token->user_identifier === $email;
    });
});

it('validates a login token with valid token and user identification', function () {
    $user = User::create(['email' => fake()->email()]);

    $login_token = MagicLogin::createToken($user->email);

    $verified = MagicLogin::verifyToken($login_token);

    assertTrue($verified->isValid());
});

it('invalidates an expired login token', function () {
    $this->expectException(ExpiredTokenException::class);

    $login_token = MagicLogin::createToken(fake()->email());

    $this->travelTo(Carbon::now()->addMinutes(60));

    MagicLogin::verifyToken($login_token);
});
