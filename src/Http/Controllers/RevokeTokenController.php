<?php

namespace Yumb\MagicLogin\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class RevokeTokenController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __invoke(Request $request): JsonResponse
    {
        request()->user()->currentAccessToken()->delete(); // @phpstan-ignore-line

        $response = ['revoked' => true];

        return ($request->expectsJson())
                ? response()->json($response)
                : back()->with($response);
    }
}
