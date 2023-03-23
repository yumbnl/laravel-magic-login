<?php

namespace Yumb\MagicLogin\Listeners;

use Illuminate\Events\Dispatcher;
use Yumb\MagicLogin\Events\TokenRequestedEvent;

class TokenEventSubscriber
{
    public function handleTokenRequested(TokenRequestedEvent $event): void
    {
        $actionClass = config('magic-login.listeners.TokenRequestedEvent');

        (new $actionClass)($event->login_token);
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            TokenRequestedEvent::class => 'handleTokenRequested',
        ];
    }
}
