<?php

namespace Yumb\MagicLogin\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Yumb\MagicLogin\Enums\UserIdType;
use Yumb\MagicLogin\Helpers\TokenGenerator;
use Yumb\MagicLogin\Models\MagicLoginToken;

class MagicLoginTokenFactory extends Factory
{
    protected $model = MagicLoginToken::class;

    public function definition()
    {
        return [
            'user_identifier' => fake()->email(),
            'user_id_type' => UserIdType::EMAIL(),
            'expires_at' => Carbon::now()->addMinutes(config('magic-login.token_expires_after')),
        ];
    }
}

