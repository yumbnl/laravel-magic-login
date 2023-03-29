<?php

use Yumb\MagicLogin\Actions\SendTokenAction;
use Yumb\MagicLogin\Enums\UserIdType;

return [
    'user_model' => 'App\Models\User',
    'id_type_cols' => [
        UserIdType::EMAIL() => 'email',
        UserIdType::SMS() => 'phone',
    ],
    'token_length' => 5,
    'token_expires_after' => 15, // Minutes
    'token_characters' => '2345679CDEFGHJKLMNPRSTUVWXYZ',
    'listeners' => [
        'TokenRequestedEvent' => SendTokenAction::class,
    ],
    'urls' => [
        'magictoken' => [
            'request' => 'magic-login/request-token',
            'verify' => 'magic-token/verify-token',
            'revoke' => 'magic-login/revoke-token'
        ]
    ]
];
