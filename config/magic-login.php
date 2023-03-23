<?php

use Yumb\MagicLogin\Actions\SendTokenAction;

return [
    'token_length' => 5,
    'token_expires_after' => 15, // Minutes
    'token_characters' => '2345679CDEFGHJKLMNPRSTUVWXYZ',
    'listeners' => [
        'TokenRequestedEvent' => SendTokenAction::class
    ]
];
