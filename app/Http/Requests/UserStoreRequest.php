<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UserStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255',function($attribute, $value, $fail){
                $data =   DB::table('tenants')->where('data->email', $value)->exists();
                if($data){
                    $fail('The email in the tenant data is already taken');
                }
            }],
            'password' => ['required','min:4','max:32'],
            'domain'=>['required', 'max:255', function($attribute, $value, $fail) {
                if(!preg_match('/^[a-zA-Z0-9-]+$/', $value)){
                    return $fail('Domain should only contain letters, numbers, and hyphens.');
                }
                $domain = $value .'.'.getDomainName();
                $data =  DB::table('tenants')->where('data->domain', $domain)->exists();
                if($data){
                    $fail('The domain already taken');
                }

            }]
        ];
    }
}
