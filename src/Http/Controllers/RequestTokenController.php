<?php

namespace Yumb\MagicLogin\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Yumb\MagicLogin\Enums\UserIdType;
use Yumb\MagicLogin\Facades\MagicLogin;
use Yumb\MagicLogin\Http\Requests\RequestTokenRequest;

class RequestTokenController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __invoke(RequestTokenRequest $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        MagicLogin::createToken(
            $validated['user_identifier'],
            $validated['user_id_type'] ?? UserIdType::EMAIL(),
            $validated['intended_url'] ?? '/'
        );

        $response = ['requested' => true];

        return ($request->expectsJson())
                ? response()->json($response)
                : back()->with($response);
    }
}
