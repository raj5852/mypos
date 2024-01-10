<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends FormRequest
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
        $id = $this->route('customer');

        return [
            'name' => ['required', 'max:256'],
            'email' => ['nullable', Rule::unique('customers', 'email')->ignore($id)],
            'phone' => ['nullable', 'max:2000'],
            'phone' => ['required', 'unique:customers,phone,' . $id],
            'opening_receivable' => ['nullable', 'numeric'],
            'opening_payable' => ['nullable', 'numeric'],
        ];
    }
}
