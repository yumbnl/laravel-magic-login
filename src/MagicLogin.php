<?php

namespace Yumb\MagicLogin;

use Yumb\MagicLogin\Enums\TokenStatus;
use Yumb\MagicLogin\Enums\UserIdType;
use Yumb\MagicLogin\Exceptions\ConsumedTokenException;
use Yumb\MagicLogin\Exceptions\ExpiredTokenException;
use Yumb\MagicLogin\Exceptions\InvalidUserIdException;
use Yumb\MagicLogin\Models\MagicLoginToken;

class MagicLogin
{
    public function createToken(string $user_identifier, string|null $user_id_type = null, string $intended_url = null)
    {
        return MagicLoginToken::updateOrCreate([
            'user_identifier' => $user_identifier,
            'user_id_type' => $user_id_type ?? UserIdType::EMAIL(),
        ], [
            'intended_url' => $intended_url,
        ]);
    }

    public function getToken(string $user_identifier, string|null $user_id_type = null)
    {
        $id_type = $user_id_type ?? UserIdType::EMAIL();
        
        return MagicLoginToken::where(
                'user_identifier',
                $user_identifier
            )
            ->first();
    }

    public function verifyToken(MagicLoginToken $login_token): TokenStatus
    {
        if ($login_token->status->isConsumed()) {
            throw new ConsumedTokenException;
        }

        if ($login_token->expires_at->isPast()) {
            $login_token->status = TokenStatus::EXPIRED;
            $login_token->save();

            throw new ExpiredTokenException;
        }

        if (! $this->validateUserId($login_token)) {
            $login_token->status = TokenStatus::INVALID_USERID;
            $login_token->save();

            throw new InvalidUserIdException;
        }

        return TokenStatus::VALID;
    }

    public function validateUserId(MagicLoginToken $login_token): bool
    {
        $userModel = config('magic-login.user_model');

        return $userModel::where(
            config('magic-login.id_type_cols.'.$login_token->user_id_type->value),
            $login_token->user_identifier
        )->exists();
    }

    public function getPersonalAccessToken(MagicLoginToken $login_token, string $device_id = null): string
    {
        $user = $this->getUserFromToken($login_token);

        $device_id = $device_id ?? 'UnknownDevice-'.fake()->randomDigitNotZero();

        return $user->createToken($device_id)->plainTextToken;
    }

    public function getUserFromToken(MagicLoginToken $login_token)
    {
        $userModel = config('magic-login.user_model');

        return $userModel::where(
            config('magic-login.id_type_cols.'.$login_token->user_id_type->value),
            $login_token->user_identifier
        )->first();
    }
}
