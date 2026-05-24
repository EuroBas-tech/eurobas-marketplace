<?php

namespace App\Http\Requests\Api;

use App\CPU\Helpers;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user()->id,
            'bio' => 'nullable|string',
            // Mobile uploads the avatar as a multipart file part (the
            // endpoint must be hit with POST, not PUT, for PHP to parse the
            // body). The old `nullable|string` rule rejected the file.
            'image' => 'nullable|image|max:10240',
            'phone_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'show_phone_number' => 'nullable|boolean',
            'show_email_address' => 'nullable|boolean',
            'native_language' => 'nullable|string|max:50',
            'street_address_type' => 'nullable|string|max:50',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'country' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'street_address' => 'nullable|string|max:255',
            'show_location_data' => 'nullable|boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => Helpers::error_processor($validator)], 422)
        );
    }
}
