<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierUpdateRequest extends FormRequest
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
        $id = $this->route('supplier');

        return [
            'name' => ['required', 'max:256'],
            'email' => ['nullable', Rule::unique('suppliers', 'email')->ignore($id)],
            'address' => ['nullable', 'max:2000'],
            'phone' => ['required', 'unique:suppliers,phone,' . $id],

        ];
    }
}
