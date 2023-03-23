<?php

namespace Yumb\MagicLogin\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendTokenEmailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $token,
        public string $email,
        public Carbon $expires_at
    ) {
    }
}
