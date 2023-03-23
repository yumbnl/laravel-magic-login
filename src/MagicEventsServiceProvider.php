<?php

namespace Yumb\MagicLogin;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Yumb\MagicLogin\Listeners\TokenEventSubscriber;

class MagicEventsServiceProvider extends EventServiceProvider
{
    protected $listen = [];

    protected $subscribe = [
        TokenEventSubscriber::class,
    ];

    public function boot()
    {
        parent::boot();
    }
}
