<?php

namespace Yumb\MagicLogin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestTokenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_identifier' => 'required|string',
            'user_id_type' => 'sometimes|string',
            'intended_url' => 'sometimes|string',
        ];
    }
}
