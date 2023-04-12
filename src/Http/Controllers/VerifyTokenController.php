<?php

namespace Yumb\MagicLogin\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Yumb\MagicLogin\Exceptions\InvalidTokenException;
use Yumb\MagicLogin\Facades\MagicLogin;
use Yumb\MagicLogin\Http\Requests\VerifyTokenRequest;
use Yumb\MagicLogin\Models\MagicLoginToken;

class VerifyTokenController extends BaseController
{
    public function __invoke(VerifyTokenRequest $request)
    {
        $validated = $request->validated();

        if (! request()->manual && ! request()->hasValidSignature()) {
            abort(401);
        }

        $login_token = MagicLoginToken::where([
            ['token', $validated['token']],
            ['user_identifier', $validated['user_identifier']],
        ])
            ->latest()
            ->first();

        throw_if(empty($login_token->exists), InvalidTokenException::class);

        $status = MagicLogin::verifyToken($login_token);

        if ($status->isValid()) {
            $login_token->consume();
        }

        if ($request->expectsJson()) {
            return response()->json([
                'token' => MagicLogin::getPersonalAccessToken($login_token, request()->device_name),
            ]);
        }

        $user = MagicLogin::getUserFromToken($login_token);

        auth()->login($user);

        return redirect()->intended($login_token->intended_url);
    }
}
