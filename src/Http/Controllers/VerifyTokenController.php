<?php

namespace Yumb\MagicLogin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
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

        $status = MagicLogin::verifyToken($login_token);

        $login_token->consumed_at = Carbon::now();
        $login_token->status = $status;
        $login_token->save();

        // $token = $user->createToken('SPROUTCLOUD-APP')->plainTextToken;

        // return response()->json([
        //     'user' => [
        //         'name' => $user->name,
        //     ],
        //     'token' => $token,
        // ]);
    }
}
