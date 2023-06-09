<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertTrue;
use Symfony\Component\HttpFoundation\Response;
use Yumb\MagicLogin\Events\TokenRequestedEvent;
use Yumb\MagicLogin\Exceptions\ExpiredTokenException;
use Yumb\MagicLogin\Facades\MagicLogin;
use Yumb\MagicLogin\Mail\LoginTokenMail;
use Yumb\MagicLogin\Tests\TestModels\User;

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
    Event::fake([TokenRequestedEvent::class]);

    $user = User::create(['email' => fake()->email()]);

    $response = $this->post(route('magictoken.web.request'), ['email' => $user->email]);

    Event::assertDispatched(TokenRequestedEvent::class, function ($e) use ($user) {
        return $e->login_token->user_identifier === $user->email;
    });
});

it('sends login token email when token has been requested', function () {
    Mail::fake();

    $user = User::create(['email' => fake()->email()]);

    $this->postJson(route('magictoken.api.request'), ['email' => $user->email])
        ->assertStatus(Response::HTTP_ACCEPTED);

    Mail::assertQueued(LoginTokenMail::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email);
    });
});

it('will create new user when requesting login for non-existing user', function () {
    Mail::fake();

    $email = 'fake@nodomain.com';

    $this->postJson(route('magictoken.api.request'), ['email' => $email])
        ->assertStatus(Response::HTTP_ACCEPTED);

    $user = User::whereEmail($email)->first();

    assertNotNull($user);

    Mail::assertQueued(LoginTokenMail::class, function ($mail) use ($email) {
        return $mail->hasTo($email);
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
