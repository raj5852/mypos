<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:256'],
            'email' => ['nullable', 'unique:customers,email'],
            'address' => ['nullable', 'max:2000'],
            'phone' => ['required', 'unique:customers,phone'],
            // 'opening_receivable' => ['nullable', 'numeric'],
            // 'opening_payable' => ['nullable', 'numeric'],
        ];
    }
}
