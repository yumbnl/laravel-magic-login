<?php

namespace Yumb\MagicLogin\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class RevokeTokenController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __invoke(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate(['logout_all' => 'sometimes|boolean']);

        if (isset($request->logout_all)) {
            $request->user()->tokens()->delete(); // @phpstan-ignore-line
        } 
        else {
            $request->user()->currentAccessToken()->delete(); // @phpstan-ignore-line
        } 

        $response = ['revoked' => true];

        return ($request->expectsJson())
                ? response()->json($response, Response::HTTP_ACCEPTED)
                : back()->with($response);
    }
}
