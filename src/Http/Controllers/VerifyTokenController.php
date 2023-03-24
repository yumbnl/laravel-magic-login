<?php

namespace Yumb\MagicLogin\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Yumb\MagicLogin\Http\Requests\VerifyTokenRequest;
use Yumb\MagicLogin\Facades\MagicLogin;
use Yumb\MagicLogin\Models\MagicLoginToken;

class VerifyTokenController extends BaseController
{
    public function __invoke(VerifyTokenRequest $request)
    {
        $validated = $request->validated();

        $login_token = MagicLoginToken::where('token', $validated['token'])
                        ->andWhere('user_udentifier', $validated['user_identifier'])
                        ->latests()
                        ->first();

        $token_status = MagicLogin::verifyToken($login_token);

        if( ! $token_status->isValid() )
            $token_status->throwError();

        // $token = $user->createToken('SPROUTCLOUD-APP')->plainTextToken;

        // return response()->json([
        //     'user' => [
        //         'name' => $user->name,
        //     ],
        //     'token' => $token,
        // ]);
    }
}
