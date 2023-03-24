<?php

namespace Yumb\MagicLogin\Http\Controllers;

use Carbon\Carbon;
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

        $login_token = MagicLoginToken::where([
                            ['token', $validated['token']],
                            ['user_udentifier', $validated['user_identifier']],
                        ])
                        ->latest()
                        ->first();

        throw_if(! $login_token->exists, InvalidTokenException::class);

        $status = MagicLogin::verifyToken($login_token);

        if($status->isVerified())
            $login_token->consume();

        // $token = $user->createToken('SPROUTCLOUD-APP')->plainTextToken;

        // return response()->json([
        //     'user' => [
        //         'name' => $user->name,
        //     ],
        //     'token' => $token,
        // ]);
    }
}
