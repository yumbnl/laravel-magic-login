<?php

namespace Yumb\MagicLogin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Yumb\MagicLogin\Enums\UserIdType;

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
            'email' => 'sometimes|email',
            'phone' => 'sometimes|string',
            'user_id_type' => 'sometimes|string',
            'intended_url' => 'sometimes|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (! isset($this->user_identifier) && isset($this->email)) {
            $this->merge([
                'user_identifier' => $this->email,
                'user_id_type' => UserIdType::EMAIL(),
            ]);
        }

        if (! isset($this->user_identifier) && isset($this->phone)) {
            $this->merge([
                'user_identifier' => $this->phone,
                'user_id_type' => UserIdType::SMS(),
            ]);
        }
    }
}
