<?php

namespace Yumb\MagicLogin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yumb\MagicLogin\Enums\UserIdType;
use Yumb\MagicLogin\Helpers\TokenGenerator;
use Carbon\Carbon;

class MagicLoginToken extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'token',
        'user_identifier',
        'user_id_type',
        'intended_url',
        'expires_at',
    ];

    protected $casts = [
        'user_id_type' => UserIdType::class,
        'expires_at' => 'datetime',
        'consumed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (MagicLoginToken $login_token) {
            if(!isset($login_token->token))
                $login_token->token = (new TokenGenerator)->getToken();

            if(!isset($login_token->user_id_type))
                $login_token->user_id_type = UserIdType::EMAIL();

            if(!isset($login_token->expires_at))
                $login_token->expires_at = Carbon::now()->addMinutes(config('magic-login.token_expires_after'));
        });
    }
}
