<?php

namespace Yumb\MagicLogin\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Yumb\MagicLogin\Models\MagicLoginToken;

class TokenRequestedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public MagicLoginToken $login_token,
    ) {}
}