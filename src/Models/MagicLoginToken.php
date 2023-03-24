<?php

namespace Yumb\MagicLogin\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yumb\MagicLogin\Enums\TokenStatus;
use Yumb\MagicLogin\Enums\UserIdType;
use Yumb\MagicLogin\Events\TokenRequestedEvent;
use Yumb\MagicLogin\Helpers\TokenGenerator;

/**
 * Yumb\MagicLogin\Models\MagicLoginToken
 *
 * @property string $token
 * @property string $user_identifier
 * @property string $user_id_type
 * @property string $status
 * @property string $intended_url
 * @property Carbon $expires_at
 * @property Carbon $consumed_at
 */
class MagicLoginToken extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'token',
        'user_identifier',
        'user_id_type',
        'status',
        'intended_url',
        'expires_at',
        'consumed_at',
    ];

    protected $casts = [
        'user_id_type' => UserIdType::class,
        'status' => TokenStatus::class,
        'expires_at' => 'datetime',
        'consumed_at' => 'datetime',
    ];

    public function consume()
    {
        $this->consumed_at = Carbon::now();
        $this->status = TokenStatus::CONSUMED();
        $this->save();
    }

    protected static function booted(): void
    {
        static::creating(function (MagicLoginToken $login_token) {
            $login_token->setToken();
            $login_token->setExpiresAt();
        });

        static::created(function (MagicLoginToken $login_token) {
            TokenRequestedEvent::dispatch($login_token);
        });

        static::updating(function (MagicLoginToken $login_token) {
            $login_token->setToken();
            $login_token->setExpiresAt();

            TokenRequestedEvent::dispatch($login_token);
        });
    }

    private function setToken(): void
    {
        if (! isset($this->token)) {
            $this->token = (new TokenGenerator)->getToken();
        }
    }

    private function setExpiresAt(): void
    {
        if (! isset($this->expires_at)) {
            $this->expires_at = Carbon::now()->addMinutes(config('magic-login.token_expires_after'));
        }
    }
}
