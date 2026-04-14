<?php

namespace App\Http\Requests\Api;

use App\CPU\Helpers;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'account_type' => 'required|in:individual,company',
            'agree' => 'required|accepted',
            'password' => [
                'required',
                'min:8',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/[a-z]/', $value)) {
                        $fail('Password must contain at least one lowercase letter');
                    }
                    if (!preg_match('/[A-Z]/', $value)) {
                        $fail('Password must contain at least one uppercase letter');
                    }
                    if (!preg_match('/\d/', $value)) {
                        $fail('Password must contain at least one number');
                    }
                },
            ],
            'password_confirmation' => 'required|same:password',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => Helpers::error_processor($validator)], 422)
        );
    }
}
