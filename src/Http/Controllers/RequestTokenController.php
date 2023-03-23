<?php

namespace Yumb\MagicLogin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Yumb\MagicLogin\Enums\UserIdType;
use Yumb\MagicLogin\Facades\MagicLogin;
use Yumb\MagicLogin\Http\Requests\RequestTokenRequest;

class RequestTokenController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __invoke(RequestTokenRequest $request): JsonResponse
    {
        $validated = $request->validated();

        MagicLogin::createToken(
            $validated['user_identifier'],
            $validated['user_id_type'] ?? UserIdType::EMAIL(),
            $validated['intended_url'] ?? '/'
        );

        return response()->json([
            'requested' => true,
        ]);
    }
}
