<?php

namespace Yumb\MagicLogin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyTokenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_identifier' => 'required|string',
            'token' => 'required|string',
        ];
    }
}
