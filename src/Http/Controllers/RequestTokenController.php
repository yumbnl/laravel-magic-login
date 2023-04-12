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

        $userModel = config('magic-login.user_model');

        $user = $userModel::where(
            config('magic-login.id_type_cols.'.$validated['user_id_type']),
            $validated['user_identifier']
        )->first();

        if (! $user && config('magic-login.magic_new_user')) {
            $name = ($validated['user_id_type'] === UserIdType::EMAIL())
                ? ucfirst(substr($validated['user_identifier'], 0, strrpos($validated['user_identifier'], '@')))
                : config('magic-login.default_user_name');

            $userModel::create([
                'name' => $name,
                'email' => $validated['user_identifier'], // TODO: add other types
            ]);
        }

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
