<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name_on_card' => ['required', 'string', 'min:3', 'max:100'],
            'password' => ['sometimes', 'required', 'min:8', 'max:20'],
            'address' => ['required', 'string', 'min:3', 'max:50'],
            'city' => ['required', 'string', 'min:2', 'max:20'],
            'state' => ['required', 'string', 'min:2', 'max:20'],
            'zip_code' => ['required', 'string', 'min:5', 'max:15'],
        ];
    }
}
